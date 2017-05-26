@php
@endphp
@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>{{ucfirst($type)}} {{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
        @if($type == 'transaction')
            <div>
                <form>
                    <div class="control-group">
                        <label class="control-label">Choose Cash and Bank Account</label>
                        <div class="controls">
                            <select name="cash_account_id" onchange="this.form.submit()">
                                <option value="0">All Account</option>
                                @foreach($balance as $val)
                                    <option @if($account == $val->cash_account_id) selected @endif value="{{$val->cash_account_id}}">{{$val->cash_account_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Choose Date Range</label>
                        <div class="controls">
                            <input value="{{$start}}" id="checkin" type="text" name="checkin_date" />
                            <input value="{{$end}}" id="checkout" type="text" name="checkout_date" />
                            <input type="submit" style="vertical-align: top" class="btn btn-primary">
                        </div>
                    </div>
                    <input type="hidden" name="type" value="transaction">
                </form>
            </div>
        @endif
        <div style="float: right">
            <a href="{{route('back.excel.bank')}}?start={{$start}}&end={{$end}}" class="btn btn-success">Export to CSV</a>
        </div>
        <div style="clear: both;"></div>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                @if($type == 'transaction')
                <div class="text-center">
                    <h3>{{date('j F Y', strtotime($start))}} - {{date('j F Y', strtotime($end))}}</h3>
                </div>
                @endif
                <div class="widget-box">
                    <div class="widget-title">
                        <ul class="nav nav-tabs">
                            <li class="{{($type == 'balance') ? 'active' : ''}}"><a href="{{route('back.report.cash')}}">Balance Report</a></li>
                            <li class="{{($type == 'transaction') ? 'active' : ''}}"><a href="{{route('back.report.cash')}}?type=transaction">Detail Transaction</a></li>
                        </ul>
                    </div>
                    <div class="widget-content tab-content">
                        <div id="balance" class="tab-pane {{($type == 'balance') ? 'active' : ''}}">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($balance) > 0)
                                    @php $totalBalance = 0; @endphp
                                    @foreach($balance as $val)
                                        <tr class="odd gradeX">
                                            <td>{{$val->cash_account_name}}</td>
                                            <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->cash_account_amount)}}</td>
                                        </tr>
                                        @php $totalBalance = $totalBalance + $val->cash_account_amount; @endphp
                                    @endforeach
                                    <tr>
                                        <td class="summary-td" style="text-align: right">TOTAL</td>
                                        <td class="summary-td">{{\App\Helpers\GlobalHelper::moneyFormat($totalBalance)}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="3" style="text-align: center">No Data Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div id="transaction" class="tab-pane {{($type == 'transaction') ? 'active' : ''}}">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Account</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($transaction) > 0)
                                    @php $totalCredit = $totalDebit = 0; @endphp
                                    @foreach($transaction as $val)
                                        <tr class="odd gradeX">
                                            <td>{{date('j F Y', strtotime($val->created_at))}}</td>
                                            <td>{{\App\CashAccount::getName($val->cash_account_id)}}</td>
                                            <td>{!!  $val->desc !!}</td>
                                            <td>{{($val->type == 1) ? \App\Helpers\GlobalHelper::moneyFormatReport($val->amount) : 0}}</td>
                                            <td>{{($val->type == 2) ? \App\Helpers\GlobalHelper::moneyFormatReport($val->amount) : 0}}</td>
                                            @php $totalCredit = ($val->type == 2) ? $totalCredit + $val->amount : $totalCredit  @endphp
                                            @php $totalDebit = ($val->type == 1) ? $totalDebit + $val->amount : $totalDebit  @endphp
                                        </tr>
                                        {{--@php $totalBalance = $totalBalance + $val->cash_account_amount; @endphp--}}
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="summary-td" style="text-align: right">TOTAL</td>
                                        <td class="summary-td">{{\App\Helpers\GlobalHelper::moneyFormat($totalDebit)}}</td>
                                        <td class="summary-td">{{\App\Helpers\GlobalHelper::moneyFormat($totalCredit)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="summary-td" style="text-align: right">TOTAL BALANCE</td>
                                        <td colspan="2" class="summary-td" style="text-align: center">{{\App\Helpers\GlobalHelper::moneyFormat($totalCredit - $totalDebit)}}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="3" style="text-align: center">No Data Found</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection