@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">@lang('module.propertyFloor')</a> </div>
        <h1>@lang('module.propertyFloor')</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">@lang('web.addButton') @lang('module.propertyFloor')</a>
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('web.name')</th>
                                <th>Status</th>
                                <th>@lang('web.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->property_floor_name}}</td>
                                        <td>{!!\App\Helpers\GlobalHelper::setActivationStatus($val->property_floor_status)!!}</td>
                                        <td>
                                            <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->property_floor_id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> @lang('web.edit')</a>
                                            <a onclick="return confirm('@lang('msg.confirmDelete', ['data' => $val->property_floor_name])')"
                                               class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->property_floor_id])}}"
                                               title="delete"><i class="icon-trash" aria-hidden="true"></i> @lang('web.delete')
                                            </a>
                                            @if($val->property_floor_status == 0)
                                                <a onclick="return confirm('@lang('msg.confirmActivate', ['data' => $val->property_floor_name])')" href="{{route("$route_name.change-status", ['id' => $val->property_floor_id, 'status' => $val->property_floor_status])}}"><i class="icon-check" aria-hidden="true"></i> @lang('web.setActive')</a>
                                            @else
                                                <a onclick="return confirm('@lang('msg.confirmActivate', ['data' => $val->property_floor_name])')" href="{{route("$route_name.change-status", ['id' => $val->property_floor_id, 'status' => $val->property_floor_status])}}"><i class="icon-remove" aria-hidden="true"></i> @lang('web.setNotActive')</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" style="text-align: center">@lang('msg.noData')</td>
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
