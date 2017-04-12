<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
    /**
     * @param $filter
     * @return mixed
     */
    public function guestBill($filter) {
        $where[] = ['booking_header.checkout', '=', 1];

        $getBooking = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_code, room_list, first_name, last_name, checkin_date, checkout_date,
                            (select count(*) from booking_room where booking_id = booking_header.booking_id) as room_num,
                            booking_header.partner_id, partner_name, booking_header.type, booking_status,checkout,
                            (select total_payment from booking_payment where booking_id = booking_header.booking_id and type = 1 limit 1) as down_payment,
                            booking_header.grand_total, (select SUM(total_payment) from booking_extracharge where booking_id = booking_header.booking_id GROUP BY booking_id) as extra,
                            (select SUM(total_payment) from booking_payment where payment_method IN (1,2) AND booking_id = booking_header.booking_id GROUP BY booking_id) as total_cash,
                            (select SUM(total_payment) from booking_payment where payment_method = 3 AND booking_id = booking_header.booking_id GROUP BY booking_id) as total_credit,
                            (select SUM(total_payment) from booking_payment where payment_method = 4 AND booking_id = booking_header.booking_id GROUP BY booking_id) as total_bank,
                            (select SUM(total_payment) from booking_payment where type = 5 AND booking_id = booking_header.booking_id GROUP BY booking_id) as refund,
                            (select SUM(total_payment) from booking_payment where type <> 5 AND booking_id = booking_header.booking_id GROUP BY booking_id) as total_received,
                            (select name from users where id = booking_header.created_by) as creby, (select name from users where id = booking_header.updated_by) as modby
                            '))
            ->join('guests', 'booking_header.guest_id', '=', 'guests.guest_id')
            ->leftJoin('partners', 'booking_header.partner_id', '=', 'partners.partner_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($where)
            ->whereBetween('checkin_date', [$filter['start'], $filter['end']])
            ->paginate(config('app.limitPerPage'));

        $booking = array();
        foreach($getBooking as $row) {
            $booking[] = $row;
        }

        $data['booking'] = $booking;
        $data['link'] = $getBooking->links();

        return $data;
    }

    public function downPayment($filter, $down = 1) {
        $whereAll[] = ['booking_payment.type', '=', 1];
        $whereCashFo = [
            ['booking_payment.type', '=', $down],
            ['payment_method', '=', 1]
        ];

        $whereCashBo = [
            ['booking_payment.type', '=', $down],
            ['payment_method', '=', 2]
        ];

        $whereCredit = [
            ['booking_payment.type', '=', $down],
            ['payment_method', '=', 3]
        ];

        $whereBank = [
            ['booking_payment.type', '=', $down],
            ['payment_method', '=', 4]
        ];

        $dataAll = DB::table('booking_header')
                    ->select(DB::raw('booking_header.booking_id, booking_header.booking_code, booking_payment.created_at, room_list,
                        (select total_payment from booking_payment where booking_id = booking_header.booking_id and payment_method IN (1,2) limit 1) as total_cash,
                        (select total_payment from booking_payment where booking_id = booking_header.booking_id and payment_method = 3 limit 1) as total_credit,
                        (select total_payment from booking_payment where booking_id = booking_header.booking_id and payment_method = 4 limit 1) as total_bank,
                        total_payment,
                        (select name from users where id = booking_header.created_by) as creby'))
                    ->join('booking_payment', 'booking_header.booking_id', '=', 'booking_payment.booking_id')
                    ->orderBy('booking_header.booking_id', 'desc')
                    ->where($whereAll)
                    ->whereBetween('booking_payment.created_at', [$filter['start'], $filter['end']])
                    ->get();


        $datacashFo = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_header.booking_code, booking_payment.created_at, room_list, total_payment,
                        (select name from users where id = booking_header.created_by) as creby'))
            ->join('booking_payment', 'booking_header.booking_id', '=', 'booking_payment.booking_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($whereCashFo)
            ->whereBetween('booking_payment.created_at', [$filter['start'], $filter['end']])
            ->get();

        $datacashBo = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_header.booking_code, booking_payment.created_at, room_list, total_payment,
                        (select name from users where id = booking_header.created_by) as creby'))
            ->join('booking_payment', 'booking_header.booking_id', '=', 'booking_payment.booking_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($whereCashBo)
            ->whereBetween('booking_payment.created_at', [$filter['start'], $filter['end']])
            ->get();

        $dataCredit = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_header.booking_code, booking_payment.created_at, room_list, total_payment,
                        bank_name, cc_type_name,
                        (select name from users where id = booking_header.created_by) as creby'))
            ->join('booking_payment', 'booking_header.booking_id', '=', 'booking_payment.booking_id')
            ->join('banks', 'banks.bank_id', '=', 'booking_payment.bank')
            ->join('cc_types', 'cc_types.cc_type_id', '=', 'booking_payment.cc_type_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($whereCredit)
            ->whereBetween('booking_payment.created_at', [$filter['start'], $filter['end']])
            ->get();

        $dataBank = DB::table('booking_header')
            ->select(DB::raw('booking_header.booking_id, booking_header.booking_code, booking_payment.created_at, room_list, total_payment,
                        cash_account_name,
                        (select name from users where id = booking_header.created_by) as creby'))
            ->join('booking_payment', 'booking_header.booking_id', '=', 'booking_payment.booking_id')
            ->join('cash_accounts', 'booking_payment.bank_transfer_recipient', '=', 'cash_accounts.cash_account_id')
            ->orderBy('booking_header.booking_id', 'desc')
            ->where($whereBank)
            ->whereBetween('booking_payment.created_at', [$filter['start'], $filter['end']])
            ->get();

        $data['all'] = $dataAll;
        $data['cashfo'] = $datacashFo;
        $data['cashbo'] = $datacashBo;
        $data['credit'] = $dataCredit;
        $data['bank'] = $dataBank;

        return $data;
    }

    public function source($filter) {
        $data = DB::table('partners')
                        ->select(DB::raw('partner_name, (SELECT SUM(grand_total) from booking_header
                                WHERE booking_status = 2 and partner_id = partners.partner_id GROUP BY partner_id) AS total_bills'))
                        ->leftJoin('booking_header', 'booking_header.partner_id', '=', 'partners.partner_id')
                        ->whereBetween('booking_header.checkout_date', [$filter['start'], $filter['end']])
                        ->get();
        return $data;
    }
}