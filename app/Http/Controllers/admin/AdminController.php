<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Ticket\Ticket;
use App\Models\Traid\Market\Market;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use App\Models\vip\VipUsers;
use App\Models\Wallet;
use App\Models\Webazin\Acl\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $orderCount = MarketOrder::count();
        $marketCount = Market::count();
        $ticketCount = Ticket::where('ticket_id', null)->whereIn('status', ['new', 'user'])->count();
        $vipUser = VipUsers::where('expire_at', '>', Carbon::now())->count();
        $vipIncomeDay = Wallet::where('description', 'Like', '%vip%')
            ->whereDate('created_at', Carbon::today())
            ->whereType('decrement')->sum('price');
        return view('admin.dashboard.index', compact('userCount', 'orderCount', 'marketCount', 'ticketCount', 'vipUser', 'vipIncomeDay'));
    }

    public function admins()
    {
        $admins = Admin::all();
        $roles = Role::all();

        return view('admin.admin.index', compact('admins', 'roles'));
    }

    public function admin($id)
    {
        $admin = Admin::findOrFail($id);
        $roles = Role::all();

        return view('admin.admin.edit', compact('admin', 'roles'));
    }

    public function adminEdit(Request $request, $id)
    {

        $request->validate([
            'role_id' => 'required',
        ]);
        $admin = Admin::findOrFail($id);
        $admin->update($request->only('email', 'mobile', 'name'));

        $admin->update($request->only('is_sms_login') + [
                'is_code_set' => $request->is_sms_login == 1 ? 0 : 1
            ]);

        $admin->assignedRole($request->role_id);
        flash(Lang::get('operation completed successfully'))->important()->success();

        return back();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'email' => 'required|unique:admins|email',
            'mobile' => 'required|unique:admins',
            'password' => 'required|min:6'
        ]);

        $admin = Admin::create($request->only('name', 'mobile', 'email') + [
                'password' => Hash::make($request->password),
                'api_token' => Str::random(60),
                'is_code_set' => 1
            ]);
        $admin->assignedRole($request->role_id);

        flash(Lang::get('operation completed successfully'))->success()->important();

        return back();
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6,confirmed',
            'admin_id' => 'required|exists:admins,id'
        ]);
        $admin = Admin::find($request->admin_id);
        $admin->update([
            'password' => Hash::make($request->password)
        ]);
        flash(Lang::get('operation completed successfully'))->success();

        return back();
    }

    public function changeTheme($theme)
    {
        Auth::guard('admin')->user()->update([
            'theme' => $theme
        ]);

        return back();
    }

    public function destroy($admin)
    {
        $admin = Admin::findOrFail($admin);
        $admin->delete();

        flash(Lang::get('operation completed successfully'))->success();
        return back();
    }

}
