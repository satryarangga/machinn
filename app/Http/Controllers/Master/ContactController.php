<?php

namespace App\Http\Controllers\Master;

use App\Contact;
use App\ContactGroup;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class ContactController extends Controller
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
     * @var
     */
    private $group;

    /**
     * @var string
     */
    private $parent;

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new Contact();

        $this->module = 'contact';

        $this->group = ContactGroup::where('contact_group_status', 1)->get();

        $this->parent = 'partner';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!UserRole::checkAccess($subModule = 4, $type = 'read')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['model'] = $this->model;
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
        if(!UserRole::checkAccess($subModule = 4, $type = 'create')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['group'] = $this->group;
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
        if(!UserRole::checkAccess($subModule = 4, $type = 'create')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'contact_name'  => 'required|max:75|min:3',
            'contact_group_id'  => 'required',
            'contact_phone'  => 'required|max:25',
        ]);

        $this->model->create([
            'contact_name'   => $request->input('contact_name'),
            'contact_phone'   => $request->input('contact_phone'),
            'contact_address'   => $request->input('contact_address'),
            'contact_group_id'   => $request->input('contact_group_id'),

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
        if(!UserRole::checkAccess($subModule = 4, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['group'] = $this->group;
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
        if(!UserRole::checkAccess($subModule = 4, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'contact_name'  => 'required|max:75|min:3',
            'contact_phone'  => 'required|max:25',
        ]);

        $data = $this->model->find($id);

        $data->contact_name = $request->input('contact_name');
        $data->contact_phone = $request->input('contact_phone');
        $data->contact_address = $request->input('contact_address');
        $data->contact_group_id = $request->input('contact_group_id');

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
        if(!UserRole::checkAccess($subModule = 4, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data = $this->model->find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $data->contact_status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successChangeStatus'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        if(!UserRole::checkAccess($subModule = 4, $type = 'delete')){
            return view("auth.unauthorized");
        }
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', __('msg.successDelete'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
