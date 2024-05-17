<?php

namespace App\Broadcasting;

use App\Models\Admin\Admin;
use App\Models\User;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Notifications\Notification;

class FirebaseChannel
{
    protected $user;

    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param \App\Models\User|Admin $user
     *
     * @return array|bool
     */
    public function join($user)
    {
        $this->user = $user;
    }

    public function send($notifiable, Notification $notification)
    {
        try {
            foreach ($notifiable->fcms as $fcms) {
                $message = $notification->toFirebase($notifiable);
                $data = [
                    "to" => $fcms->token,
                    "notification" =>
                        [
                            "title" => $message['title'],
                            "body" => $message['message'],
                            "icon" => asset(Setting::get('logo')),
                            'click_action' => $message['url']
                        ],

                ];
                $dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . env('FIREBASE_TOKEN'),
                    'Content-Type: application/json',
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                curl_exec($ch);
            }
        } catch (\Exception $exception) {
            //
        }
    }
}
