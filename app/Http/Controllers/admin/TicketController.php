<?php

namespace App\Http\Controllers\admin;

use App\Jobs\SendNotificationToUserJob;
use App\Models\Anstiket;
use App\Models\Categorytiket;
use App\Models\Ticket\Ticket;
use App\Models\Tiket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\Jalalian;

class TicketController extends Controller
{

    public function index()
    {
//        $category = Categorytiket::all();
//        $tikets = Tiket::orderBy('created_at', 'desc')->get();
//        $users = User::whereRole(1)->get();

        return view('admin.ticket.index');
//        return view('admin.ticket.index', compact('tikets', 'category', 'users'));
    }

    public function show($id)
    {
        return view('admin.ticket.show', compact('id'));
    }
}
