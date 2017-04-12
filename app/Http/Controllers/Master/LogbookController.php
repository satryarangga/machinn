<?php

namespace App\Http\Controllers\Master;

use App\Department;
use App\Logbook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LogbookController extends Controller
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
    private $dept;

    /**
     * @var string
     */
    private $parent;

    const cacheKey = 'logbook';

    public function __construct()
    {
        $this->middleware('auth');

        $this->model = new Logbook();

        $this->module = 'logbook';

        $this->dept = Department::where('department_status', 1)->get();

        $this->parent = 'info';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Cache::forget(self::cacheKey);
        $data['parent_menu'] = $this->parent;
        $data['model'] = $this->model;
        $rows = Logbook::where('logbook_status', 1)->where('done', 0)->paginate(config('limitPerPage'));
        $store = Logbook::where('logbook_status', 1)->where('done', 0)->where('to_date', date('y-m-d'))->get();
        $data['rows'] = $rows;
        Cache::forever(self::cacheKey,$store);
        return view("master.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['parent_menu'] = $this->parent;
        $data['dept'] = $this->dept;
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
        $this->validate($request,[
            'logbook_message'  => 'required|max:250',
        ]);

        $this->model->create([
            'logbook_message'   => $request->input('logbook_message'),
            'to_dept_id'   => $request->input('to_dept_id'),
            'to_date'   => $request->input('to_date'),
            'created_by'   => Auth::id(),
        ]);



        $message = GlobalHelper::setDisplayMessage('success', 'Success to save new data');
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
        $data['parent_menu'] = $this->parent;
        $data['dept'] = $this->dept;
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
        $this->validate($request,[
            'logbook_message'  => 'required|max:250',
        ]);

        $data = $this->model->find($id);

        $data->logbook_message = $request->input('logbook_message');
        $data->to_dept_id = $request->input('to_dept_id');
        $data->to_date = $request->input('to_date');
        $data->updated_by = Auth::id();

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to update data');
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
        $data = $this->model->find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $data->logbook_status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to change status of logbook');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function done($id) {
        $data = $this->model->find($id);

        $data->done = 1;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', 'Success to set done reminder');
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}