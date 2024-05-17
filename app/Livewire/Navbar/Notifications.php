<?php

namespace App\Livewire\Navbar;

use App\Helpers\Helper;
use App\Livewire\refreshComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Notifications extends Component
{

    public $notificationCount;
    public $unreadNotifications;

    public function getListeners()
    {
        $adminId = Auth::guard('admin')->check() ? Auth::guard('admin')->id() : 'null';
        $userId = Auth::check() ? Auth::id() : 'null';
        $prefix = Helper::getBroadcasterPrefix();
        return [
            "echo:" . $prefix . "private-App.Models.Admin.Admin.{$adminId},.Illuminate\Notifications\Events\BroadcastNotificationCreated" => 'notifyNewNotification',
            "echo:" . $prefix . "private-App.Models.User.{$userId},.Illuminate\Notifications\Events\BroadcastNotificationCreated" => 'notifyNewNotification',
            "refreshComponent" => 'mount',
        ];
    }

    public function mount()
    {
        if (Auth::check()) {
            if (Request::is('wa-admin') || Request::is('wa-admin/*')) {
                $this->notificationCount = Auth::guard('admin')->user()->unreadNotifications()->count();
                $this->unreadNotifications = Auth::guard('admin')->user()->unreadNotifications;
            } else {
                $this->notificationCount = Auth::user()->unreadNotifications()->count();
                $this->unreadNotifications = Auth::user()->unreadNotifications;
            }
        } else {
            $this->notificationCount = 0;
            $this->unreadNotifications = [];
        }
    }

    public function render()
    {
        return view('livewire.navbar.notifications');
    }

    public function markAll()
    {
        if (Request::is('wa-admin') || Request::is('wa-admin/*')) {
            foreach (Auth::guard('admin')->user()->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
            $this->notificationCount = 0;
            $this->unreadNotifications = [];
        } else {
            foreach (Auth::user()->unreadNotifications as $notification) {
                $notification->markAsRead();
            }
            $this->notificationCount = 0;
            $this->unreadNotifications = [];
        }

        flash(Lang::get('operation completed successfully'))->success()->livewire($this);
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
}
