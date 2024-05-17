<?php

namespace App\Http\Controllers\Panel\Ticket;


use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketCategory;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
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
        return view('panel.ticket.index');
    }

    public function show($id)
    {
        return view('panel.ticket.show',compact('id'));
    }
}
