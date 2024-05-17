<?php

namespace App\Models;

use App\Models\Balance\Balance;
use App\Models\Bnb\BnbData;
use App\Models\Btc\BtcData;
use App\Models\Card\Card;
use App\Models\Eth\EthData;
use App\Models\Traits\User\MustVerifyDoc;
use App\Models\Traits\User\MustVerifyMobile;
use App\Models\Tron\TronData;
use App\Models\User\UserDocument;
use App\Models\User\UserEvent;
use App\Models\vip\VipUsers;
use App\Models\Webazin\Fcm\Fcm;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Lang;
use Morilog\Jalali\Jalalian;

class User extends Authenticatable
{
    use HasFactory, Notifiable, MustVerifyMobile, MustVerifyDoc, UserEvent,MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'doc_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    protected $appends = ['active', 'created_at_fa', 'status_html', 'balance', 'level_fa', 'document_status', 'document_status_text', 'status_color', 'status_text', 'level_img'];


    public function tronData()
    {
        return $this->hasOne(TronData::class, 'user_id', 'id');
    }

    public function btcData()
    {
        return $this->hasOne(BtcData::class, 'user_id', 'id');
    }

    public function ethData()
    {
        return $this->hasOne(EthData::class, 'user_id', 'id');
    }

    public function bnbData()
    {
        return $this->hasOne(BnbData::class, 'user_id', 'id');
    }

    public function balances()
    {
        return $this->hasMany(Balance::class);
    }

    public function getBalanceAttribute()
    {
        return $this->belongsTo(Balance::class, 'id', 'user_id')->where('currency', 'IRT')->sum('balance');
    }

    public function getActiveAttribute()
    {
        if ($this->mobile_status && $this->docs && optional($this->docs)->status == 1) {
            return true;
        }

        return false;
    }

    public function getDocumentStatusAttribute()
    {
        if ($this->hasVerifiedDoc()) {
            $html = "<label class='badge badge-info'>" . Lang::get('document status') . "<span> " . Lang::get('confirmation') . "</span ></label >";
        } else {
            if (!$this->docs) {
                $html = "<label class='badge badge-info'>" . Lang::get('document status') . "<span> " . Lang::get('waiting for upload') . "</span ></label >";
            } else {
                $html = $this->docs->status_fa;
            }
        }
        return $html;
    }

    public function getDocumentStatusTextAttribute()
    {
        if ($this->hasVerifiedDoc()) {
            $html = Lang::get('document status is', ['status' => Lang::get('confirmation')]);
        } else {
            if (!$this->docs) {
                $html = Lang::get('document status is', ['status' => Lang::get('waiting for upload')]);
            } else {
                $html = $this->docs->status_fa;
            }
        }
        return $html;
    }

    public function getLevelFaAttribute()
    {
        switch ($this->level) {
            case 'bronze' :
                return Lang::get('bronze');
            case 'silver' :
                return Lang::get('silver');
            case 'gold' :
                return Lang::get('golden');
            default:
                break;
        }

    }

    public function getLevelImgAttribute()
    {
        switch ($this->level) {
            case 'bronze' :
                return asset('images/profile/medal.png');
            case 'silver' :
                return asset('images/profile/medal.png');
            case 'gold' :
                return asset('images/profile/medal.png');
            default:
                break;
        }

    }

    public function getCreatedAtFaAttribute()
    {
        $date = Jalalian::forge($this->created_at)->ago();

        return "<span class='badge badge-info btn-block'><i class='fa fa-clock-o'></i>$date</span >";
    }

    public function getStatusHtmlAttribute()
    {
        $html = '';
        if ($this->hasVerifiedEmail() && $this->hasVerifiedMobile() && $this->hasVerifiedDoc()) {
            $html .= '<span class="badge badge-success btn-block"><i class="fa fa-check"></i> ' . Lang::get('final approval') . ' </span >';
        } else {
            if (!$this->hasVerifiedMobile()) {
                $html .= '<span class="badge badge-danger btn-block" ><i class="fa fa-ban"></i> ' . Lang::get('mobile') . ' </span >';
            }
            if ($this->docs) {
                if ($this->hasVerifiedDoc()) {
                    $html .= '<span class="badge badge-success btn-block" ><i class="fa fa-check"></i> ' . Lang::get('awaiting confirmation of the document') . '</span >';
                }
            }
            if (!$this->hasVerifiedDoc()) {
                $html .= '<span class = "badge badge-danger btn-block"><i class="fa fa-ban"></i> ' . Lang::get('waiting for upload') . ' </span>';
            }

            if (!$this->hasVerifiedEmail()) {
                $html .= '<span class = "badge badge-danger btn-block"><i class="fa fa-ban"></i> ' . Lang::get('awaiting email Confirmation') . ' </span>';
            }
        }

        return $html;
    }

    public function getStatusTextAttribute()
    {
        $html = '';
        if ($this->hasVerifiedEmail() && $this->hasVerifiedMobile() && $this->hasVerifiedDoc()) {
            $html .= Lang::get('final approval');
        } else {
            if (!$this->hasVerifiedMobile()) {
                $html .= Lang::get('mobile');
            }
            if ($this->docs) {
                if ($this->hasVerifiedDoc()) {
                    $html .= Lang::get('awaiting confirmation of the document');
                }
            }
            if (!$this->hasVerifiedDoc()) {
                $html .= Lang::get('waiting for upload');
            }

            if (!$this->hasVerifiedEmail()) {
                $html .= Lang::get('awaiting email Confirmation');
            }
        }

        return $html;
    }

    public function getStatusColorAttribute()
    {
        $html = '';
        if ($this->hasVerifiedEmail() && $this->hasVerifiedMobile() && $this->hasVerifiedDoc()) {
            $html .= 'green';
        } else {
            if (!$this->hasVerifiedMobile()) {
                $html .= 'red';
            }
            if ($this->docs) {
                if ($this->hasVerifiedDoc()) {
                    $html .= 'green';
                }
            }
            if (!$this->hasVerifiedDoc()) {
                $html .= 'red';
            }

            if (!$this->hasVerifiedEmail()) {
                $html .= 'red';
            }
            return $html;
        }
    }


    public function isActive()
    {
        return $this->hasVerifiedMobile() && $this->hasVerifiedEmail() && $this->hasVerifiedDoc();
    }

    public function docs()
    {
        return $this->belongsTo(UserDocument::class, 'id', 'user_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class, 'user_id', 'id');
    }

    public function cardActive()
    {
        return $this->hasMany(Card::class, 'user_id', 'id')->where('status', '1');
    }

    public function fcms()
    {
        return $this->hasMany(Fcm::class, 'user_id', 'id');
    }

    public function vip()
    {
        return $this->hasOne(VipUsers::class, 'user_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(User::class, 'id', 'parent_id');
    }

}
