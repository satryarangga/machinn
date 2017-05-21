@php
@endphp
@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">{{$master_module}}</a> </div>
        <h1>Profit - Loss {{$master_module}}</h1>
    </div>
    <div class="container-fluid">
        <hr>
            <div>
                <form>
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
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                    <div class="text-center">
                        <h3>{{date('j F Y', strtotime($start))}} - {{date('j F Y', strtotime($end))}}</h3>
                    </div>
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-money"></i> </span>
                        <h5>Income</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Income Type</th>
                                <th>Total Income</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Room Transaction Income</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($roomIncome)}}</td>
                                </tr>
                                <tr>
                                    <td>Resto Income</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($restoIncome)}}</td>
                                </tr>
                                <tr>
                                    <td>Extracharge Income</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($extraIncome)}}</td>
                                </tr>
                                <tr>
                                    <td class="summary-td" style="text-align: right">TOTAL</td>
                                    <td class="summary-td">{{\App\Helpers\GlobalHelper::moneyFormat($totalIncome)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-money"></i> </span>
                        <h5>Expenses</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Expense Type</th>
                                <th>Total Expense</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($expenses as $key => $val)
                                <tr>
                                    <td>{{\App\Cost::getCostName($val->cost_id)}}</td>
                                    <td>{{\App\Helpers\GlobalHelper::moneyFormat($val->total)}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="summary-td" style="text-align: right">TOTAL</td>
                                <td class="summary-td">{{\App\Helpers\GlobalHelper::moneyFormat($totalExpense)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-money"></i> </span>
                        <h5>Profit / Loss</h5>
                    </div>
                    <div class="widget-content tab-content">
                        @php $totalAll = $totalIncome - $totalExpense @endphp
                        <h3 style="text-align: center">TOTAL {{($totalAll > 0) ? 'PROFIT' : 'LOSS'}} : {{\App\Helpers\GlobalHelper::moneyFormat($totalAll)}} </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection