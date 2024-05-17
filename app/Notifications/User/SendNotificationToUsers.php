<?php

namespace App\Notifications\User;

use anlutro\LaravelSettings\Facade as Setting;
use App\Broadcasting\FirebaseChannel;
use App\Broadcasting\SmsChanel;
use App\Helpers\Helper;
use App\Notifications\User\Traits\EmailSendToUserTriat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SendNotificationToUsers extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;


    public $title,$message,$url,$templateSms,$urlTitle,$code,$code2,$code3;
    /**
     * @var mixed|null
     */

    /**
     * Create a new notification instance.
     *
     * @param $title
     * @param $message
     * @param string $urlTitle
     * @param string $url
     * @param null $templateSms
     * @param null $code
     * @param null $code2
     * @param null $code3
     */
    public function __construct($title, $message, string $urlTitle = '', string $url = '', $templateSms = null, $code = null, $code2 = null, $code3 = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
        $this->templateSms = $templateSms;
        $this->urlTitle = $urlTitle;
        $this->code = $code;
        $this->code2 = $code2;
        $this->code3 = $code3;
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
        $channels = ['database', 'broadcast', 'mail'];
        if ($this->templateSms) {
            array_push($channels, SmsChanel::class);
        }
        if (Helper::modules()['firebase']) {
            array_push($channels, FirebaseChannel::class);
        }
        return $channels;
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
            ->subject($this->title. ' | ' . Setting::get('title'))
            ->line($this->message)
            ->action($this->urlTitle, $this->url);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'subject' => $this->title,
            'message' => $this->message,
            'action' => $this->urlTitle,
            'url' => $this->url,
        ]);
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
            'subject' => $this->title,
            'message' => $this->message,
            'action' => $this->urlTitle,
            'url' => $this->url,
        ];
    }

    public function toSms($notifiable)
    {
        return [
            'templateSms' => $this->templateSms,
            'code' => str_replace(' ', '_', $this->code),
            'code2' => str_replace(' ', '_', $this->code2),
            'code3' => str_replace(' ', '_', $this->code3),
        ];
    }

    public function toFirebase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'action' => $this->urlTitle,
            'url' => $this->url,
        ];
    }
}
