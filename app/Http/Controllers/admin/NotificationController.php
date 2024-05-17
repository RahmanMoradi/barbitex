<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller {
    public function markAsRead() {
        foreach ( Auth::user()->unreadNotifications as $notification ) {
            $notification->markAsRead();
        }
    }

    public function destroy( $id ) {
        Auth::user()->notifications()->where( 'id' , $id )->delete();

        return 1;
    }
}
