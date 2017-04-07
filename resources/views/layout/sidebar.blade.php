<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
    <ul>
        <li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'master') open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>Master</span></a>
            <ul>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Rooms</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-attribute') class="active" @endif>
                            <a href="{{route('room-attribute.index')}}">Room Attribute</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-rate-day-type') class="active" @endif>
                            <a href="{{route('room-rate-day-type.index')}}">Room Rate Day Type</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-type') class="active" @endif>
                            <a href="{{route('room-type.index')}}">Room Type</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-number') class="active" @endif>
                            <a href="{{route('room-number.index')}}">Room Number</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'room-plan') class="active" @endif>
                            <a href="{{route('room-plan.index')}}">Room Plan</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Banquet</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'banquet-event') class="active" @endif>
                            <a href="{{route('banquet-event.index')}}">Banquet Event</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'banquet') class="active" @endif>
                            <a href="{{route('banquet.index')}}">Banquet Time</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Employees</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'department') class="active" @endif>
                            <a href="{{route('department.index')}}">Department</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee-shift') class="active" @endif>
                            <a href="{{route('employee-shift.index')}}">Employee Shift</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee-status') class="active" @endif>
                            <a href="{{route('employee-status.index')}}">Employee Status</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee-type') class="active" @endif>
                            <a href="{{route('employee-type.index')}}">Employee Type</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'employee') class="active" @endif>
                            <a href="{{route('employee.index')}}">Employee</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Cost and Income</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'cost') class="active" @endif>
                            <a href="{{route('cost.index')}}">Cost</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'income') class="active" @endif>
                            <a href="{{route('income.index')}}">Income</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Extracharge</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'extracharge-group') class="active" @endif>
                            <a href="{{route('extracharge-group.index')}}">Extracharge Group</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'extracharge') class="active" @endif>
                            <a href="{{route('extracharge.index')}}">Extracharge</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Payment</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'bank') class="active" @endif>
                            <a href="{{route('bank.index')}}">Bank</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'cash-account') class="active" @endif>
                            <a href="{{route('cash-account.index')}}">Cash and Bank Account</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'credit-card-type') class="active" @endif>
                            <a href="{{route('credit-card-type.index')}}">Credit Card Type</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'tax') class="active" @endif>
                            <a href="{{route('tax.index')}}">Tax</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'settlement') class="active" @endif>
                            <a href="{{route('settlement.index')}}">Settlement</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Location</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'country') class="active" @endif>
                            <a href="{{route('country.index')}}">Country</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'province') class="active" @endif>
                            <a href="{{route('province.index')}}">Province</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Business Partner</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'partner-group') class="active" @endif>
                            <a href="{{route('partner-group.index')}}">Partner Group</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'partner') class="active" @endif>
                            <a href="{{route('partner.index')}}">Partner</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'contact-group') class="active" @endif>
                            <a href="{{route('contact-group.index')}}">Contact Group</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'contact') class="active" @endif>
                            <a href="{{route('contact.index')}}">Contact</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Property</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'property-attribute') class="active" @endif>
                            <a href="{{route('property-attribute.index')}}">Property Attribute</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'property-floor') class="active" @endif>
                            <a href="{{route('property-floor.index')}}">Property Floor</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="submenu @if(\Illuminate\Support\Facades\Request::segment(1) == 'front') open active @endif"> <a href="#"><i class="icon icon-th-list"></i> <span>Front Office</span></a>
            <ul>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Room Transaction</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'checkin') class="active" @endif>
                            <a href="{{route('checkin.index')}}">Check In</a>
                        </li>
                        <li
                            @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.index'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.create'
                            || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.edit') class="active" @endif>
                            <a href="{{route('booking.index')}}">Booking</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'room-number.view-room') class="active" @endif>
                            <a href="{{route('room-number.view-room')}}">Room View</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Guest</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.inhouse') class="active" @endif>
                            <a href="{{route('guest.inhouse')}}">In House Guest</a>
                        </li>
                        <li
                                @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.index'
                                || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.create'
                                || \Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.edit') class="active" @endif>
                            <a href="{{route('guest.index')}}">List All Guest</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.statistic') class="active" @endif>
                            <a href="{{route('guest.statistic')}}">Guest Statistic</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'guest.checkin') class="active" @endif>
                            <a href="{{route('guest.checkin')}}">Guest By Check In</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Info</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'staff.index') class="active" @endif>
                            <a href="{{route('staff.index')}}">Staff Contact</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'contact') class="active" @endif>
                            <a href="{{route('contact.index')}}">Other Contact</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'logbook') class="active" @endif>
                            <a href="{{route('logbook.index')}}">Log Book</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Cashier</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'transaction.index') class="active" @endif>
                            <a href="{{route('transaction.index')}}">Expense</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Request::segment(2) == 'pos') class="active" @endif>
                            <a href="{{route('pos.create')}}">Outlet Posting</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu2 "><a href="#"><i class="icon icon-list-alt"></i> <span>Report</span></a>
                    <ul >
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'booking.report') class="active" @endif>
                            <a href="{{route('booking.report')}}">Booking Report</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.guest-bill') class="active" @endif>
                            <a href="{{route('report.guest-bill')}}">Guest Bill Report</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.down-payment') class="active" @endif>
                            <a href="{{route('report.down-payment')}}">Deposit Report</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.cash-credit') class="active" @endif>
                            <a href="{{route('report.cash-credit')}}">Cash and Credit Report</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.front-pos') class="active" @endif>
                            <a href="{{route('report.front-pos')}}">Outlet Posting Report</a>
                        </li>
                        <li @if(\Illuminate\Support\Facades\Route::CurrentRouteName() == 'report.source') class="active" @endif>
                            <a href="{{route('report.source')}}">Business Source Report</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="submenu "> <a href="#"><i class="icon icon-th-list"></i> <span>Back Office</span></a>
            <ul>
            </ul>
        </li>
        <li class="submenu "> <a href="#"><i class="icon icon-th-list"></i> <span>POS</span></a>
            <ul>
            </ul>
        </li>
        <li class="submenu "> <a href="#"><i class="icon icon-th-list"></i> <span>House Keeping</span></a>
            <ul>
            </ul>
        </li>
    </ul>
</div>