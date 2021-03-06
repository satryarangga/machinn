<?php

namespace App;

use App\Helpers\GlobalHelper;
use Illuminate\Database\Eloquent\Model;

class OutletTransactionHeader extends Model
{
    /**
     * @var string
     */
    protected $table = 'outlet_transaction_header';

    /**
     * @var array
     */
    protected $fillable = [
        'bill_number', 'total_billed', 'total_discount', 'grand_total', 'desc', 'guest_id', 'date', 'status', 'created_by', 'audited',
        'waiters', 'guest_num', 'table_id', 'room_id', 'bill_type', 'delivery_type', 'source', 'total_tax', 'total_service', 'booking_id'
    ];

    /**
     * @var string
     */
    protected $primaryKey = 'transaction_id';

    public static function getList ($filter, $limit){
        $where[] = ['status', '<>', 4];

        $source = isset($filter['source']) ? $filter['source'] : 1;
        $where[] = ['source', '=', $source];
        if($filter['status'] != 0) {
            $where[] = ['status', '=', $filter['status']];
        }

        if(isset($filter['delivery_type']) && $filter['delivery_type'] != 0) {
            $where[] = ['delivery_type', '=', $filter['delivery_type']];
        }

        if(isset($filter['bill_number']) && $filter['bill_number'] != null){
            $where[] = ['bill_number', '=', $filter['bill_number']];
        }

        $list = parent::where($where)
                        ->whereBetween('date', [$filter['start'], $filter['end']])
                        ->orderBy('transaction_id', 'desc')
                        ->paginate($limit);

        return $list;
    }

    public static function getDetail($id) {
        $detail = OutletTransactionDetail::select('extracharge_name', 'outlet_transaction_detail.price', 'qty')
                    ->join('extracharges', 'extracharges.extracharge_id', '=', 'outlet_transaction_detail.extracharge_id')
                    ->where('transaction_id', $id)
                    ->get();

        $text = array();
        foreach($detail as $key => $val) {
            $text[] = $val->extracharge_name.' ['.GlobalHelper::moneyFormat($val->price).' x '.$val->qty.']<br />';
        }

        return implode(' ', $text);
    }

    /**
     * @param $id
     * @return string
     */
    public static function getDetailResto($id) {
        $detail = OutletTransactionDetail::select('name', 'outlet_transaction_detail.price', 'qty')
            ->join('pos_item', 'pos_item.id', '=', 'outlet_transaction_detail.extracharge_id')
            ->where('transaction_id', $id)
            ->get();

        $text = array();
        foreach($detail as $key => $val) {
            $text[] = $val->name.' ['.GlobalHelper::moneyFormat($val->price).' x '.$val->qty.']<br />';
        }

        return implode(' ', $text);
    }

    /**
     * @param $type
     * @return string
     */
    public static function getDeliveryType($type){
        if($type == 1){
            return __('web.deliveryTypeDine');
        }
        return __('web.deliveryTypeRoom');
    }

    /**
     * @param $bookingId
     * @return mixed
     */
    public static function getUnpaidResto($bookingId){
        return parent::where('booking_id', $bookingId)->where('status', '<>', '3')->sum('grand_total');
    }

    /**
     * @param $bookingId
     * @return mixed
     */
    public static function getRestoBill($bookingId){
        return parent::where('booking_id', $bookingId)->sum('grand_total');
    }
}
