<?php

namespace App\Livewire\Ticket;

use App\Http\Controllers\Traits\General\Uploadable;
use App\Livewire\Layout\Sidebar;
use App\Livewire\ValidateNotify;
use App\Models\Admin\Admin;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketCategory;
use App\Models\Traid\Market\MarketOrder;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\User\SendNotificationToUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Tickets extends Component
{
    use ValidateNotify, WithFileUploads, Uploadable, WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $subject, $message, $file, $order_id, $user_id, $category_id, $viewType, $prefix, $collapse = true, $filter;

    public function mount()
    {
        $this->clear();
        $this->viewType = (request()->is('panel') || request()->is('panel/*')) ? 'user' : 'admin';
        $this->prefix = $this->viewType == 'user' ? 'panel' : 'wa-admin';
        request()->has('user_id') ? $this->user_id = request()->get('user_id') : $this->user_id = null;
        request()->has('user_id') ? $this->collapse = false : $this->collapse = true;
    }

    public function collapse()
    {
        $this->collapse = !$this->collapse;
    }

    public function render()
    {
        $users = [];
        if ($this->viewType == 'user') {
            $user_id = Auth::id();
            $orders = MarketOrder::where('user_id', $user_id)->orderby('created_at', 'desc')->get();
        } else {
            $orders = MarketOrder::orderby('created_at', 'desc')->get();
            $users = User::all();
        }
        $tickets = $this->getTickets();

        $categories = TicketCategory::all();

        return view('livewire.ticket.tickets', compact('categories', 'orders', 'tickets', 'users'));
    }

    public function submit()
    {
        $this->requestValidate();
        $data = [
            'subject' => $this->subject,
            'message' => $this->message,
            'category_id' => $this->category_id,
            'order_id' => $this->order_id
        ];
        Ticket::Create($data + [
                'user_id' => $this->viewType == 'user' ? Auth::id() : $this->user_id,
                'role' => $this->viewType == 'user' ? 'user' : 'admin',
                'status' => $this->viewType == 'user' ? 'new' : 'admin',
                'file' => $this->file ? $this->uploadFile('ticket/image/', $this->file) : null,
            ]);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->clear();
    }

    public function close(Ticket $ticket)
    {
        $ticket->update([
            'status' => 'close'
        ]);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->emitTo(Sidebar::class, '$refresh');
        $this->render();
    }

    private function requestValidate()
    {
        if ($this->viewType == 'user') {
            $data = [
                'subject' => $this->subject,
                'message' => $this->message,
                'category_id' => $this->category_id,
                'file' => $this->file,
                'order_id' => $this->order_id
            ];
            $rules = [
                'subject' => 'required',
                'message' => 'required',
                'category_id' => 'required',
                'file' => 'nullable|file|max:10240'
            ];

        } else {
            $data = [
                'subject' => $this->subject,
                'message' => $this->message,
                'category_id' => $this->category_id,
                'file' => $this->file,
                'user_id' => $this->user_id
            ];
            $rules = [
                'subject' => 'required',
                'message' => 'required',
                'category_id' => 'required',
                'user_id' => 'required|exists:users,id',
                'file' => 'nullable|file'
            ];
        }
        $this->validateNotify($data, $rules);
        $this->validate($rules);
    }

    private function clear()
    {
        $this->subject = null;
        $this->message = null;
        $this->file = null;
        $this->order_id = null;
        $this->user_id = null;
        $this->category_id = null;
        $this->collapse = true;
    }

    public function getTickets()
    {
        $tickets = Ticket::query();
        if ($this->viewType == 'user') {
            $tickets = $tickets->where('user_id', Auth::id());
        }
        if ($this->user_id) {
            $tickets = $tickets->where('user_id', $this->user_id);
        }
        if ($this->filter) {
            $tickets = $tickets->where('status', $this->filter);
        }
        return $tickets = $tickets->where('ticket_id', null)
            ->orderBy('created_at', 'desc')->paginate();
    }
}
