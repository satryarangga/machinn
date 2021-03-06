<?php

namespace App\Http\Controllers\Master;

use App\RoomRateDateType;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\GlobalHelper;

class RoomRateDayTypeController extends Controller
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

        $this->model = new RoomRateDateType();

        $this->module = 'room-rate-day-type';

        $this->parent = 'rooms';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!UserRole::checkAccess($subModule = 1, $type = 'read')){
            return view("auth.unauthorized");
        }
        $data['days'] = $this->listOfDays();
        $rows = $this->model->paginate();
        $data['rows'] = $rows;
        $data['parent_menu'] = $this->parent;
        return view("master.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!UserRole::checkAccess($subModule = 1, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['days'] = $this->listOfDays();
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
        if(!UserRole::checkAccess($subModule = 1, $type = 'update')){
            return view("auth.unauthorized");
        }
        $day = $this->listOfDays();

        foreach($day as $key => $val){
            if($request->input('1-'.$key)){
                $weekdays[] = $val;
            }

            if($request->input('2-'.$key)){
                $weekends[] = $val;
            }
        }

        $day = implode(',', $weekdays);
        $end = implode(',', $weekends);

        $weekday = RoomRateDateType::find(1);
        $weekday->room_rate_day_type_list = $day;
        $weekday->save();

        $weekend = RoomRateDateType::find(2);
        $weekend->room_rate_day_type_list = $end;
        $weekend->save();

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successUpdateData'));
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
        if(!UserRole::checkAccess($subModule = 1, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data['parent_menu'] = $this->parent;
        $data['days'] = $this->listOfDays();
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
        if(!UserRole::checkAccess($subModule = 1, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'room_rate_day_type_name'  => 'required|max:75|min:3'
        ]);

        $data = $this->model->find($id);

        $data->room_rate_day_type_name = $request->input('room_rate_day_type_name');
        $data->room_rate_day_type_list = $request->input('room_rate_day_type_list');

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
     * @return array
     */
    protected function listOfDays() {
        return [
            '1' => __('master.monday'),
            '2' => __('master.tuesday'),
            '3' => __('master.wednesday'),
            '4' => __('master.thursday'),
            '5' => __('master.friday'),
            '6' => __('master.saturday'),
            '7' => __('master.sunday')
        ];
    }
}
