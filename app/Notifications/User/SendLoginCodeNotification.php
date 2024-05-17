<?php

namespace App\Notifications\User;

use App\Broadcasting\SmsChanel;
use App\Jobs\User\Login\RemoveValidateCodeJob;
use App\Models\User\ValidCode;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use mysql_xdevapi\Exception;
use webazin\KaveNegar\SMS;

class SendLoginCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $code;
    /**
     * @var string
     */
    public $themplate;
    /**
     * @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user;
    /**
     * @var mixed
     */
    private $validType;


    public function __construct($validType = null)
    {
        $this->user = Auth::check() ? Auth::user() : Auth::guard('api')->user();
        $this->user = Auth::check() ? Auth::user() : Auth::guard('api')->user();
        $this->validType = $validType ?: $this->user->two_factor_type;
        if ($this->validType == 'google') {
            return;
        }
        $check = ValidCode::where('user_id', Auth::check() ? Auth::id() : Auth::guard('api')->id())->count();
        if ($check > 0) {
            flash(Lang::get('you have just requested a code'))->error()->important();
            return back();
        } else {
            $randnumber = rand('1000', '9999');
            $this->code = $randnumber;
            $this->themplate = 'validatesubmit';

            $code = ValidCode::updateOrCreate([
                'user_id' => $this->user->id,
                'type' => $this->validType == 'none' ? 'email' : $this->validType,
                'code' => $this->code
            ]);
             RemoveValidateCodeJob::dispatch($code)->delay(now()->addSeconds(62));
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {

        if ($this->code){
            if ($this->validType == 'email' || $this->validType == 'none') {
                return ['mail'];
            } else {
                return [SmsChanel::class];
            }
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::get('login code'))
            ->line($this->code)
            ->line(Lang::get('code', ['code' => $this->code]));
    }

    public function toSms()
    {
        return [
            'templateSms' => $this->themplate,
            'code' => $this->code,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
