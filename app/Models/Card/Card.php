<?php

namespace App\Models\Card;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Card extends Model
{
    use HasFactory, BankNameTriat, CardEvent;

    protected $fillable = ['user_id', 'card_number', 'bank_name', 'account_number', 'sheba', 'status'];
    protected $appends = ['last_number', 'status_html', 'status_text', 'bank_name_text', 'bank_logo', 'status_color'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLastNumberAttribute()
    {
        return substr($this->card_number, -4);
    }

    public function getStatusHtmlAttribute()
    {
        if ($this->status == 0) {
            $html = '<span class="badge badge-info btn-block"><i class="fa fa-ban"></i>' . Lang::get('pending') . '</span >';
        } else if ($this->status == 1) {
            $html = '<span class="badge badge-success btn-block" ><i class="fa fa-check"></i>' . Lang::get('confirmation') . '</span >';
        } else {
            $html = '<span class="badge badge-danger btn-block"><i class="fa fa-ban"></i>' . Lang::get('failed') . '</span >';
        }

        return $html;
    }

    public function getStatusTextAttribute()
    {
        if ($this->status == 0) {
            $html = Lang::get('pending');
        } else if ($this->status == 1) {
            $html = Lang::get('confirmation');
        } else {
            $html = Lang::get('failed');
        }

        return $html;
    }

    public function getStatusColorAttribute()
    {
        if ($this->status == 0) {
            $html = 'blue';
        } else if ($this->status == 1) {
            $html = 'green';
        } else {
            $html = 'red';
        }

        return $html;
    }

    public function getBankNameTextAttribute()
    {
        return $this->getBankName($this->card_number);
    }

    public function getBankLogoAttribute()
    {
        return $this->getLogo($this->card_number);
    }

    private function getLogo($card_number)
    {
        $cards = collect($this->bankNames);
        $prefix = substr($card_number, 0, 6);
        $bank = $cards->where('prefix', $prefix)->first();
        return $bank ? asset($bank['icon']) : '';
    }

    private function getBankName($card_number)
    {
        $cards = collect($this->bankNames);
        $prefix = substr($card_number, 0, 6);
        $bank = $cards->where('prefix', $prefix)->first();

        return $bank ? $bank['name'] : '';
    }
}
