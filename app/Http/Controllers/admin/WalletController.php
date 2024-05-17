<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationToUserJob;
use App\Models\Balance\Balance;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\User\SendNotificationToUsers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class WalletController extends Controller
{


    public function list()
    {
        return view('admin.wallet.list');
    }

    public function balance()
    {
        $balances = Balance::where('user_id', '!=', 0)
            ->where('balance', '>', 0)
            ->orderByDesc('created_at')->get();

        return view('admin.wallet.balance', compact('balances'));
    }

    public function decrement()
    {
        return view('admin.wallet.decrement');
    }

}
