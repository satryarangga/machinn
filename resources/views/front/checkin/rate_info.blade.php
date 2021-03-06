<form action="{{route('checkin.rate', ['id' => $header->booking_id])}}" method="post">
    {{csrf_field()}}
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>{{strtoupper(__('web.date'))}}</th>
            <th>{{strtoupper(__('module.roomNumber'))}}</th>
            <th>{{strtoupper(__('web.roomRate'))}}</th>
            <th>{{strtoupper(__('web.roomPlanPrice'))}}</th>
            <th>DISCOUNT (%)</th>
            <th>DISCOUNT (Rp.)</th>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
          @php $total_ori = 0 @endphp
        @foreach($detail as $key => $value)
            <tr>
                <td>{{date('j F Y', strtotime($value->room_transaction_date))}}</td>
                <td>{{\App\RoomNumber::getCode($value->room_number_id)}}</td>
                <td><input style="width:100px" id="room_rate_{{$value->booking_room_id}}" data-id="{{$value->booking_room_id}}" name="room_rate[{{$value->booking_room_id}}]" onkeyup="changeRate($(this))" onchange="changeRate($(this))" type="text" value="{{$value->room_rate}}" /></td>
                <td><input style="width:100px" id="plan_rate_{{$value->booking_room_id}}" data-id="{{$value->booking_room_id}}" name="plan_rate[{{$value->booking_room_id}}]" onkeyup="changePlan($(this))" onchange="changePlan($(this))" type="text" value="{{$value->room_plan_rate}}" /></td>
                <td><input style="width:30px" id="discount_per_{{$value->booking_room_id}}" data-id="{{$value->booking_room_id}}" name="discount[{{$value->booking_room_id}}]" onkeyup="changeDiscountRatePercent($(this))" onchange="changeDiscountRatePercent($(this))" type="text" value="{{round($value->discount / ($value->room_rate + $value->room_plan_rate) * 100)}}" /></td>
                <td><input style="width:100px" id="discount_{{$value->booking_room_id}}" data-id="{{$value->booking_room_id}}" name="discount[{{$value->booking_room_id}}]" onkeyup="changeDiscountRate($(this))" onchange="changeDiscountRate($(this))" type="text" value="{{$value->discount}}" /></td>
                <td id="sub_text_{{$value->booking_room_id}}">{{\App\Helpers\GlobalHelper::moneyFormat($value->subtotal)}}</td>
                <input type="hidden" name="subtotal[{{$value->booking_room_id}}]" id="subtotal_{{$value->booking_room_id}}" value="{{$value->subtotal}}" />
                <input type="hidden" name="subtotal_ori_[{{$value->booking_room_id}}]" id="subtotal_ori_{{$value->booking_room_id}}" value="{{$value->room_rate + $value->room_plan_rate}}" />
            </tr>
            @php $total_ori = $total_ori + $value->room_rate + $value->room_plan_rate @endphp
        @endforeach
            <tr>
                <td colspan="7" style="text-align: right;font-weight: bold;font-size: 16px">GRAND TOTAL :
                    <span id="grand_rate_text">{{\App\Helpers\GlobalHelper::moneyFormat($header->grand_total)}}</span>
                    <input type="hidden" id="grand_rate" name="grand_total" value="{{$header->grand_total}}">
                    <input type="hidden" id="grand_rate_ori" name="grand_total_ori" value="{{$total_ori}}">
                </td>
            </tr>
            <tr>
                <td colspan="7" style="text-align: right;font-weight: bold;font-size: 16px"><input type="submit" value="{{strtoupper(__('web.saveChange'))}}" class="btn btn-success"></td>
            </tr>
        </tbody>
    </table>
</form>
