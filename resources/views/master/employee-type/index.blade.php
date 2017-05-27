@extends('layout.main')

@section('title', 'Home')

@section('content')

    <div id="content-header">
        <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Role</a> </div>
        <h1>Role</h1>
    </div>
    <div class="container-fluid">
        <hr>
        @if($user['employee_type_id'] == 1)
        <a class="btn btn-primary" href="{{route("$route_name.create")}}">Add New Role</a>
        @endif
        {!! session('displayMessage') !!}
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($rows) > 0)
                                @foreach($rows as $val)
                                    <tr class="odd gradeX">
                                        <td>{{$val->employee_type_name}}</td>
                                        <td>{!!\App\Helpers\GlobalHelper::setActivationStatus($val->employee_type_status)!!}</td>
                                        <td>
                                                <a style="margin-right: 20px" href="{{route("$route_name.edit", ['id' => $val->employee_type_id])}}" title="Edit"><i class="icon-pencil" aria-hidden="true"></i> Edit</a>
                                                <a onclick="return confirm('You will delete {{$val->employee_type_name}}, continue? ')"
                                                   class="delete-link" style="margin-right: 20px" href="{{route("$route_name.delete", ['id' => $val->employee_type_id])}}"
                                                   title="delete"><i class="icon-trash" aria-hidden="true"></i> Delete
                                                </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" style="text-align: center">No Data Found</td>
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