<?php

namespace App\Http\Resources;

use anlutro\LaravelSettings\Facade as Setting;
use App\Helpers\Helper;
use App\Models\Card\Card;
use App\Models\Order;
use App\Models\Ticket\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use PragmaRX\Google2FA\Support\Constants;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $google2fa = app('pragmarx.google2fa');
        $google2fa->setAlgorithm(Constants::SHA512);
        if (!$this->google2fa_secret) {
            $secret = $google2fa->generateSecretKey();
            $this->update(['google2fa_secret' => $secret]);
        }
//        $dayBuyFast = Order::where('user_id', $this->id)->whereType(1)->whereStatus(4)
//            ->whereDay('created_at', now()->day)->sum('price');
        $cards = Card::where('user_id', $this->id)->get();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar' => asset('/images/avatar.png'),
            'national_code' => $this->national_code,
            'user_name' => $this->email,
            'birthday' => $this->birthday,
            'email' => $this->email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'balance' => (string)number_format($this->balance, '0', '', ''),
            'doc_url' => $this->docs ? asset($this->docs->title) : '',
            'type' => $this->two_factor_type,
            'level_text' => $this->level_fa,
            'level_image' => $this->level_img,
            'created_at_fa' => $this->created_at_fa_text,
            'created_at_fa_text' => $this->created_at_fa_text_ago,
            'wage_p2p' => $this->wage_p2p ? $this->wage_p2p : Setting::get('wage_p2p'),
            'api_token' => $this->api_token,
            'setting' => [
                'two_factor_type' => $this->two_factor_type,
                'notification_email' => 1,
                'notification_sms' => 1,
                'notification_app' => 1,
                'google2fa_secret' => $this->google2fa_secret,
                'status' => $this->active,
                'mobile_status' => $this->mobile_verified_at,
                'status_text' => $this->status_text,
                'status_color' => $this->status_color,
                'doc_status' => $this->docs ? $this->docs->status : '-1',
                'phone_status' => (int)$this->phone_status,
                'doc_status_fa' => $this->docs ? $this->docs->status_fa_text : Lang::get('waiting for upload'),
                'doc_status_color' => $this->docs ? $this->docs->status_color : 'red',
                'card_status' => $this->cardActive->count() > 0,
                'card_status_color' => $this->cardActive->count() > 0 ? 'green' : 'red',
                'usd_price' => Setting::get('dollar_buy_pay'),
            ],
            'accountancy' => [
                'day_buy' => Helper::numberFormatPrecision($this->day_buy, 0),
                'max_buy' => Helper::numberFormatPrecision($this->max_buy, 0),
                'remaining' => Helper::numberFormatPrecision(($this->max_buy - $this->day_buy), 0),
            ],
            'info' => [
                'tickets' => [
                    'all' => Ticket::where('user_id', $this->id)->count(),
                    'open' => Ticket::where('user_id', $this->id)->where('status', 1)->count(),
                ]
            ],
            'vip' => [
                'active' => $this->vip && $this->vip->expire_at > Carbon::now(),
                'days' => optional($this->vip)->expire_at > Carbon::now() ? Carbon::now()->diffInDays(optional($this->vip)->expire_at) : 0
            ],
            'cards' => CardResource::collection($cards)
        ];
    }
}
