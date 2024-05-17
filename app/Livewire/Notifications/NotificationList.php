<?php

namespace App\Livewire\Notifications;

use App\Helpers\Helper;
use App\Livewire\Navbar\Notifications;
use App\Livewire\ValidateNotify;
use App\Models\Admin\Admin;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\User\SendNotificationToUsers;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\WithPagination;

class NotificationList extends Component
{

    use WithPagination, ValidateNotify;

    protected $paginationTheme = 'bootstrap';

    public $title, $link_title, $link, $message, $group, $path;

    public function getListeners()
    {
        $adminId = Auth::guard('admin')->check() ? Auth::guard('admin')->id() : 'null';
        $userId = Auth::check() ? Auth::id() : 'null';
        $prefix = Helper::getBroadcasterPrefix();
        return [
            "echo:" . $prefix . "private-App.Models.Admin.Admin.{$adminId},.Illuminate\Notifications\Events\BroadcastNotificationCreated" => 'notifyNewNotification',
            "echo:" . $prefix . "private-App.Models.User.{$userId},.Illuminate\Notifications\Events\BroadcastNotificationCreated" => 'notifyNewNotification',
        ];
    }

    public function mount()
    {
        if (Request::is('wa-admin/*')) {
            $this->path = 'admin';
        } else {
            $this->path = 'user';
        }
    }

    public function render()
    {
        if (Auth::check()) {
            if (Request::is('wa-admin/*')) {
                $notificationsCount = Auth::guard('admin')->user()->notifications()->count();
                $notifications = Auth::guard('admin')->user()->notifications()->paginate();
            } else {
                $notificationsCount = Auth::user()->notifications()->count();
                $notifications = Auth::user()->notifications()->paginate();
            }
        } else {
            $notificationsCount = 0;
            $notifications = [];
        }
        return view('livewire.notifications.notification-list', compact('notifications', 'notificationsCount'));
    }

    public function notifyNewNotification($notification)
    {
        if (isset($notification['action']) && $notification['action'] == 'error') {
            flash($notification['message'])->error()->livewire($this);
        } else {
            flash($notification['message'])->success()->livewire($this);
        }
        $this->mount();
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        if ($notification->unread()) {
            $notification->markAsRead();
        } else {
            $notification->markAsUnread();
        }
        $this->emitTo(Notifications::class, 'refreshComponent');
        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
    }

    public function send()
    {
        $rules = [
            'title' => 'required',
            'link_title' => 'required',
            'link' => "required",
            'message' => "required",
        ];
        $data = [
            'title' => $this->title,
            'link_title' => $this->link_title,
            'link' => $this->link,
            'message' => $this->message,
        ];

        $this->validateNotify($data, $rules);
        $this->validate($rules);
        if (!Auth::guard('admin')->user()->roles[0]->permissions->contains('name', 'send-notification')) {
            flash(Lang::get('illegal access'))->error()->livewire($this);
            $this->dispatchBrowserEvent('closeModal');
            $this->emit('$refresh');
            return;
        }
        $this->group == 'users' ? User::chunk(100, function ($collect) {
            foreach ($collect as $users) {
                try {
                    Notification::send($users,
                        new SendNotificationToUsers($this->title, $this->message, $this->link_title, $this->link));
                } catch (\Exception $exception) {
                    continue;
                }
            }
        }) : Admin::chunk(100, function ($collect) {
            foreach ($collect as $admins) {
                try {
                    Notification::send($admins,
                        new SendNotificationToAdmin($this->title, $this->message, $this->link_title, $this->link));
                } catch (\Exception $exception) {
                    continue;
                }

            }
        });


        flash(Lang::get('operation completed successfully'))->success()->livewire($this);

        $this->dispatchBrowserEvent('closeModal');
        $this->emit('$refresh');
    }
}
