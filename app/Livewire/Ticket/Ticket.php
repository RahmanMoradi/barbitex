<?php

namespace App\Livewire\Ticket;

use App\Http\Controllers\Traits\General\Uploadable;
use App\Livewire\Layout\Sidebar;
use App\Livewire\ValidateNotify;
use App\Models\Admin\Admin;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\User\SendNotificationToUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Morilog\Jalali\Jalalian;

class Ticket extends Component
{
    use ValidateNotify, WithFileUploads, Uploadable;

    public $ticket_id, $message, $file, $viewType;

    protected $rules = [
        'message' => 'required',
        'file' => 'nullable|file|max:10240'
    ];

    public function mount($id)
    {
        $this->ticket_id = $id;
        $this->message = '';
        $this->file = '';
        $this->viewType = \request()->is('wa-admin/*') ? 'admin' : 'user';
    }

    public function render()
    {
        $ticket = \App\Models\Ticket\Ticket::with('answers')->findOrFail($this->ticket_id);

        $answers = $ticket->answers->groupBy(function ($item) {
            return Jalalian::forge($item->created_at)->format('Y-m-d');
        });
        return view('livewire.ticket.ticket', compact('ticket', 'answers'));
    }

    public function answer()
    {
        $data = [
            'message' => $this->message,
            'file' => $this->file
        ];
        $this->validateNotify($data, $this->rules);
        $this->validate();
        $tiket = \App\Models\Ticket\Ticket::where('id', $this->ticket_id)->first();

        $answere = \App\Models\Ticket\Ticket::create([
            'message' => $this->message,
            'ticket_id' => $this->ticket_id,
            'user_id' => $this->viewType == 'user' ? Auth::id() : $tiket->user_id,
            'role' => $this->viewType,
            'file' => $this->file ? $this->uploadFile('ticket/image/', $this->file) : null,
        ]);

        $tiket->update([
            'status' => $this->viewType
        ]);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->emitTo(Sidebar::class, 'refreshComponent');
        return redirect(url($this->viewType == 'admin' ? 'wa-admin/ticket' : 'panel/ticket', ['id' => $this->ticket_id]));
    }

    public function close()
    {
        $ticket = \App\Models\Ticket\Ticket::with('answers')->findOrFail($this->ticket_id);
        $ticket->update([
            'status' => 'close'
        ]);
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
        $this->emitTo(Sidebar::class, 'refreshComponent');
        $this->mount($this->ticket_id);
    }
}
