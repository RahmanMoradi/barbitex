<?php

namespace App\Http\Controllers\admin;

use App\Jobs\SendNotificationToUserJob;
use App\Models\Balance;
use App\Models\Card;
use App\Models\Currency;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::where('role', 1)->get();

        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::where('id', $id)
            ->with('cards')
            ->first();
        return view('admin.users.edit', compact('user'));
    }
}
