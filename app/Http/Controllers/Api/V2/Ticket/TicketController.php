<?php

namespace App\Http\Controllers\Api\V2\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketCategory;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{

    public function category()
    {
        $categories = TicketCategory::all()->toArray();

        return $this->response(1, $categories, [], Lang::get('ticket categories'));
    }

    public function index(Request $request)
    {
        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        $tickets = Ticket::query();
        $tickets = $tickets->orderByDesc('updated_at');
        $tickets = $tickets
            ->where('ticket_id', null)
            ->where('user_id', Auth::guard('api')->id());
        if ($request->has('status')) {
            if ($request->get('status') != 0) {
                $tickets = $tickets->whereStatus($request->get('status'));
            }
        }
        $tickets = $tickets->with('answers')
            ->paginate($per_page);
        $list = TicketResource::collection($tickets)->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response(1, $data, $meta, Lang::get('tickets registered by the user'));
    }

    public function show($id)
    {
        $ticket = Ticket::with('answers')->find($id);

        return $this->response(1, new TicketResource($ticket), [], Lang::get('tickets registered by the user'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
            'category_id' => 'required',
            'file' => 'file|nullable',
        ]);
        if ($validator->fails()) {
            return $this->validateResponseFail($validator);
        }
        $ticket = Ticket::Create($request->only('subject', 'message', 'category_id') + [
                'user_id' => Auth::guard('api')->id(),
                'role' => 'user',
                'status' => 'new',
                'file' => $request->has('file') ? 'uploads/' . Storage::disk('public')->put('ticket', $request->file('file')) : null,

            ]);

//        Notification::send(User::whereRole(2)->get(), new SendNotificationToAdmin('TicketCreate', $ticket->id));

        $per_page = $request->get('per_page') ? $request->get('per_page') : $this::PER_PAGE;
        $tickets = Ticket::query();
        $tickets = $tickets->orderByDesc('updated_at');
        $tickets = $tickets->where('user_id', Auth::guard('api')->id());
        if ($request->has('status')) {
            if ($request->get('status') != 0) {
                $tickets = $tickets->whereStatus($request->get('status'));
            }
        }
        $tickets = $tickets->with('answers')
            ->paginate($per_page);
        $list = TicketResource::collection($tickets)->response()->getData(true);
        $data = $list['data'];
        $meta = $list['meta'];
        return $this->response(1, $data, $meta, Lang::get('tickets registered by the user'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required',
            'message' => 'required',
            'file' => 'file|nullable',
        ]);
        if ($validator->fails()) {
            return $this->validateResponseFail($validator);
        }
        $answere = Ticket::create($request->only('ticket_id', 'message') + [
                'user_id' => Auth::guard('api')->id(),
                'role' => 'user',
                'file' => $request->has('file') ? 'uploads/' . Storage::disk('public')->put('ticket', $request->file('file')) : null,
            ]);

        $ticket = Ticket::with('answers')->find($request->ticket_id);
        $ticket->update([
            'status' => 'user'
        ]);
//        Notification::send(User::whereRole(2)->get(), new SendNotificationToAdmin('TicketAnswer', $ticket->id));

        return $this->response(1, new TicketResource($ticket), [], Lang::get('operation completed successfully'));
    }
}
