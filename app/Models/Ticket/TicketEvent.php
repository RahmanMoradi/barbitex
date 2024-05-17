<?php

namespace App\Models\Ticket;

use App\Models\Admin\Admin;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\User\SendNotificationToUsers;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;

trait TicketEvent
{
    protected static function boot()
    {
        parent::boot();
        Ticket::created(function ($ticket) {
            $urlTitle = Lang::get('view tickets');

            if ($ticket->ticket_id == null) {
                $url = "/ticket/$ticket->id";
                $title = Lang::get('new ticket');
                $message = Lang::get('ticket registered', ['ticketId' => $ticket->id]);
                $code = $ticket->id;
            } else {
                $url = "/ticket/$ticket->ticket_id";
                $title = Lang::get('ticket answer');
                $message = Lang::get('ticket answered', ['ticketId' => $ticket->id]);
                $code = $ticket->id;
            }
            if ($ticket->role == 'admin') {
                $prefix = 'panel';
                $smsTemplate = $ticket->ticket_id == null ? "ticketCreate" : "ticketAnswer";

                Notification::send(User::find($ticket->user_id),
                    new SendNotificationToUsers($title, $message, $urlTitle, url($prefix . $url), $smsTemplate, $code));
            } else {
                $prefix = 'wa-admin';
                $smsTemplate = $ticket->ticket_id == null ? "adminTicketCreate" : "adminTicketUpdate";
                foreach (Admin::all() as $admin) {
                    Notification::send($admin,
                        new SendNotificationToAdmin($title, $message, $urlTitle, url($prefix . $url), $smsTemplate, $code));
                }
            }
        });
    }
}
