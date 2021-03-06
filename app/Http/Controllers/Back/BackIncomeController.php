<?php

namespace App\Http\Controllers\Back;

use App\AccountReceivable;
use App\BackIncome;
use App\CashTransaction;
use App\Income;
use App\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\GlobalHelper;
use App\CashAccount;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class BackIncomeController extends Controller
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

    /**
     *
     */
    private $type;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('language');

        $this->model = new BackIncome();

        $this->module = 'back-income';

        $this->parent = 'back-transaction';

        $this->type = [1 => __('web.backIncomeTypeCapital'), 2 => __('web.backIncomeTypeAccount'), 3 => __('web.others')];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 16, $type = 'read')){
            return view("auth.unauthorized");
        }
        $start = ($request->input('checkin_date')) ? $request->input('checkin_date') : date('Y-m-d', strtotime("-1 month"));
        $end = ($request->input('checkout_date')) ? $request->input('checkout_date') : date('Y-m-d');
        $type = ($request->input('type')) ? $request->input('type') : 0;

        $data['parent_menu'] = ($request->input('parent') == 'acc') ? 'account-receivable' : $this->parent;
        $data['typeIncome'] = $type;
        $data['start'] = $start;
        $data['end'] = $end;
        $rows = $this->model->getIncome($start, $end, $type);
        $data['rows'] = $rows;
        return view("back.".$this->module.".index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!UserRole::checkAccess($subModule = 16, $type = 'create')){
            return view("auth.unauthorized");
        }
        $this->type = [1 => __('web.backIncomeTypeCapital'), 2 => __('web.backIncomeTypeAccount'), 3 => __('web.others')];
        $data['unpaidBook'] = AccountReceivable::getUnpaidBooking();
        $data['type'] = $this->type;
        $data['income'] = Income::all();
        $data['cash_account'] = CashAccount::all();
        $data['parent_menu'] = $this->parent;
        return view("back.".$this->module.".create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!UserRole::checkAccess($subModule = 16, $type = 'create')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'date'  => 'required',
            'amount'  => 'required',
            'cash_account_recipient'  => 'required',
            'type'  => 'required'
        ]);

        if($request->input('type') == '2'){
            $bookingId = $request->input('account_receivable_id');

            AccountReceivable::where('booking_id', $bookingId)
                ->update([
                    'paid'  => 1
                ]);
        }

        $created = $this->model->create([
            'date'      => $request->input('date'),
            'amount'      => $request->input('amount'),
            'desc'      => $request->input('description'),
            'income_id'      => ($request->input('income_id')) ? $request->input('income_id') : 0,
            'account_receivable_id' => $request->input('account_receivable_id'),
            'type'      => $request->input('type'),
            'cash_account_recipient'      => $request->input('cash_account_recipient'),
            'created_by'      => Auth::id(),
            'status'        => 0
        ]);

        // INSERT TO CASH TRANSACTION
        $insertCashTransaction = [
            'income_id'        => $created->id,
            'amount'            => $request->input('amount'),
            'desc'              => BackIncome::getType($created),
            'cash_account_id'   => $request->input('cash_account_recipient'),
            'payment_method'    => 4,
            'type'              => 2
        ];

        CashTransaction::insert($insertCashTransaction);

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
        if(!UserRole::checkAccess($subModule = 16, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->type = [1 => __('web.backIncomeTypeCapital'), 2 => __('web.backIncomeTypeAccount'), 3 => __('web.others')];
        $data['parent_menu'] = $this->parent;
        $data['unpaidBook'] = AccountReceivable::getUnpaidBooking();
        $data['type'] = $this->type;
        $data['income'] = Income::all();
        $data['cash_account'] = CashAccount::all();
        $data['row'] = $this->model->find($id);
        return view("back.".$this->module.".edit", $data);
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
        if(!UserRole::checkAccess($subModule = 16, $type = 'update')){
            return view("auth.unauthorized");
        }
        $this->validate($request,[
            'date'  => 'required',
            'amount'  => 'required',
            'type'  => 'required',
            'cash_account_recipient'  => 'required'
        ]);

        if($request->input('type') == '2'){
            $bookingId = $request->input('account_receivable_id');

            AccountReceivable::where('booking_id', $bookingId)
                ->update([
                    'paid'  => 1
                ]);
        }

        $data = $this->model->find($id)->update([
            'date'      => $request->input('date'),
            'amount'      => $request->input('amount'),
            'desc'      => $request->input('description'),
            'type'      => $request->input('type'),
            'income_id'      => ($request->input('income_id')) ? $request->input('income_id') : 0,
            'account_receivable_id' => $request->input('account_receivable_id'),
            'cash_account_recipient'      => $request->input('cash_account_recipient'),
            'updated_by'      => Auth::id()
        ]);

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
        if(!UserRole::checkAccess($subModule = 16, $type = 'update')){
            return view("auth.unauthorized");
        }
        $data = $this->model->find($id);

        if($status == 1){
            $active = 0;
        } else {
            $active = 1;
        }

        $data->status = $active;

        $data->save();

        $message = GlobalHelper::setDisplayMessage('success', __('msg.successChangeStatus'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDelete($id) {
        if(!UserRole::checkAccess($subModule = 16, $type = 'delete')){
            return view("auth.unauthorized");
        }
        $this->model->find($id)->delete();
        $message = GlobalHelper::setDisplayMessage('success', __('msg.successDelete'));
        return redirect(route($this->module.".index"))->with('displayMessage', $message);
    }
}
