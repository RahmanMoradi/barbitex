<?php

namespace App\Models\User;

use App\Models\Admin\Admin;
use App\Models\User;
use App\Notifications\Admin\SendNotificationToAdmin;
use App\Notifications\User\SendNotificationToUsers;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Notification;

trait UserDocumentEvent
{
    protected static function boot()
    {
        parent::boot();
        static::created(function ($document) {
            $userEmail = User::find($document->user_id)->email;
            $title = Lang::get('certificate of identification');
            $message = Lang::get('the new document was registered by', ['email' => $userEmail]);
            $urlTitle = Lang::get('list of documents');
            $url = url("wa-admin/documents");
            $smsTemplate = "adminDocumentStore";

            Notification::send(Admin::all(),
                new SendNotificationToAdmin($title, $message, $urlTitle, $url, $smsTemplate, $userEmail));
        });

        static::updated(function ($document) {
            $userEmail = User::find($document->user_id)->email;
            $title = Lang::get('certificate of identification');
            $message = Lang::get('the new document was registered by', ['email' => $userEmail]);
            $urlTitle = Lang::get('list of documents');
            $url = url("wa-admin/documents");
            $smsTemplate = "adminDocumentStore";


            if ($document->status == 'new') {
                Notification::send(Admin::all(),
                    new SendNotificationToAdmin($title, $message, $urlTitle, $url, $smsTemplate, $userEmail));
            }
            Notification::send(User::find($document->user_id),
                new SendNotificationToUsers($title, Lang::get('your id was changed in the system', ['status' => $document->status_fa_text]),
                    Lang::get('authentication'), url('panel/authentication/profile'), 'approve', $userEmail, Lang::get('certificate of identification'), $document->status_fa_text));
        });
    }
}
