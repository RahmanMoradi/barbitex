<?php

namespace App\Broadcasting;

use App\Models\User;
use webazin\KaveNegar\Exceptions\ApiException;
use webazin\KaveNegar\Exceptions\HttpException;
use webazin\KaveNegar\SMS;

class SmsChanel
{
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
     * @param User $user
     *
     * @return array|bool
     */
    public function join($user)
    {
        //
    }

    public function send($notifiable, $notification)
    {
        $message = $notification->toSms($notifiable);
        $template = $message['templateSms'];
        $sms = new SMS;
        $mobile = $notifiable->mobile;
        $code = $message['code'];
        $code2 = $message['code2'] ?? null;
        $code3 = $message['code3'] ?? null;
        str_replace(' ', $code, '_');
        try {
            if (isset($code2) && isset($code3)) {
                $result = $sms->VerifyLookup3($mobile, $code, $code2, $code3, $template);
            } elseif (isset($code2)) {
                $result = $sms->VerifyLookup2($mobile, $code, $code2, $template);
            } else {
                $result = $sms->VerifyLookup($mobile, $code, $template);
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
