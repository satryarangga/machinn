<?php

namespace App\Http\Controllers\Master;

use App\PropertyFloor;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class PropertyFloorController extends Controller
{
    /**
     * @var
     */
    private $model;

    /**
     * @var
     */
    private $module;

    /**
     * @var string
     */
    private $parent;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new PropertyFloor();

        $this->module = 'property-floor';

        $this->parent = 'property';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!UserRole::checkAccess($subModule = 5, $type = 'read')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $rows = $this->model->paginate();
        $data['rows'] = $rows;
        return view("master.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!UserRole::checkAccess($subModule = 5, $type = 'create')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        return view("master.".$this->module.".create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 5, $type = 'create')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'property_floor_name'  => 'required|max:25'
        ]);

        $this->model->create([
            'property_floor_name'   => $request->input('property_floor_name')
        ]);

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successCreateData'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!UserRole::checkAccess($subModule = 5, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['row'] = $this->model->find($id);
        return view("master.".$this->module.".edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!UserRole::checkAccess($subModule = 5, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'property_floor_name'  => 'required|max:25'
        ]);

        $data = $this->model->find($id);

        $data->property_floor_name = $request->input('property_floor_name');

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successUpdateData'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @param $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($id, $status) {
        if(!UserRole::checkAccess($subModule = 5, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data = $this->model->find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $data->property_floor_status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successChangeStatus'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        if(!UserRole::checkAccess($subModule = 5, $type = 'delete')){
            return view("auth.unauthorized");
        }
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', __('msg.successDelete'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
