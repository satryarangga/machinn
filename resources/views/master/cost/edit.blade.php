@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route("$route_name.index")}}">{{$master_module}}</a> <a href="#" class="current">Edit {{$master_module}}</a> </div>
        <h1>{{$master_module}}</h1>
    </div>
    <div class="container-fluid"><hr>
        <a class="btn btn-success" href="javascript:history.back()">Back to list</a>
        @foreach($errors->all() as $message)
            <div style="margin: 20px 0" class="alert alert-error">
                {{$message}}
            </div>
        @endforeach
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-pencil"></i> </span>
                        <h5>Edit {{$master_module}} Data</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form id="form-wizard" class="form-horizontal" action="{{route("$route_name.update", ['id' => $row->cost_id])}}" method="post">
                            {{csrf_field()}}
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">{{$master_module}} Name</label>
                                    <div class="controls">
                                        <input id="name" required type="text" value="{{$row->cost_name}}" name="cost_name" />
                                    </div>
                                </div>
                            </div>
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">{{$master_module}} Amount</label>
                                    <div class="controls">
                                        <input value="{{$row->cost_amount}}" type="number" name="cost_amount">
                                    </div>
                                </div>
                            </div>
                            <div id="form-wizard-1" class="step">
                                <div class="control-group">
                                    <label class="control-label">{{$master_module}} Type</label>
                                    <div class="controls">
                                        <select name="cost_type">
                                            @foreach($type as $key => $val)
                                                <option @if($row->cost_type == $key) selected="selected" @endif value="{{$key}}">{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input id="next" class="btn btn-primary" type="submit" value="Save" />
                                <div id="status"></div>
                            </div>
                            <div id="submitted"></div>
                            {{ method_field('PUT') }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection