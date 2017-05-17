@extends('layout.main')

@section('title', 'Home')

@section('content')
    @php $route_name = (\Illuminate\Support\Facades\Request::segment(1) == 'back') ? 'back.transaction' : 'transaction'; @endphp
    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Expenses</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div>
            <form>
                {{--<div class="control-group">--}}
                    {{--<label class="control-label">Choose Status</label>--}}
                    {{--<div class="controls">--}}
                        {{--<select name="status" onchange="this.form.submit()">--}}
                            {{--<option @if($filter['status'] == 0) selected @endif value="0">Not Approved</option>--}}
                            {{--<option @if($filter['status'] == 1) selected @endif value="1">Approved</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="control-group">
                    <label class="control-label">Choose Date Range</label>
                    <div class="controls">
                        <input value="{{$filter['start']}}" id="checkin" type="text" name="start" />
                        <input value="{{$filter['end']}}" id="checkout" type="text" name="end" />
                        <input type="submit" style="vertical-align: top" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">Add New Expense</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Cost Type</th>
                                <th>From Account</th>
                                <th>Description</th>
                                <th>Amount</th>
                                {{--<th>Status</th>--}}
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{date('j F Y', strtotime($val->date))}}</td>
                                        <td>{{\App\Cost::getCostName($val->cost_id)}}</td>
                                        <td>{{\App\CashAccount::getName($val->cash_account_id)}}</td>
                                        <td>{{$val->desc}}</td>
                                        <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->amount)}}</td>
                                        {{--<td>{{\App\FrontExpenses::getStatusName($val->status)}}</td>--}}
                                        <td>
                                            @if($val->status != 1)
                                                <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->id])}}" title="Edit">
                                                    <i class="icon-pencil" aria-hidden="true"></i> Edit
                                                </a>
                                                <a onclick="return confirm('You will delete the data, continue? ')"
                                                   class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->id])}}"
                                                   title="delete"><i class="icon-trash" aria-hidden="true"></i> Delete
                                                </a>
                                            @endif
                                            {{--<div class="btn-group">--}}
                                                {{--<button @if($val->status == 1) disabled @endif data-toggle="dropdown" class="btn dropdown-toggle">Action--}}
                                                    {{--<span class="caret"></span>--}}
                                                {{--</button>--}}
                                                {{--<ul class="dropdown-menu">--}}
                                                    {{--@if($val->status != 1)--}}
                                                        {{--<li><a href="{{route($route_name.'.change-status', ['id' => $val->id, 'status' => 1])}}"><i class="icon-check"></i>Approve</a></li>--}}
                                                        {{--<li><a href="{{route($route_name.'.change-status', ['id' => $val->id, 'status' => 3])}}"><i class="icon-remove"></i>Delete</a></li>--}}
                                                    {{--@endif--}}
                                                {{--</ul>--}}
                                            {{--</div>--}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" style="text-align: center">No Data Found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $rows->links() }}
            </div>
        </div>
    </div>

@endsection