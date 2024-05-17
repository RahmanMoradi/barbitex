<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Morilog\Jalali\Jalalian;

class UserDocument extends Model
{
    use HasFactory, UserDocumentEvent;

    protected $guarded = ['id'];
    protected $appends = ['status_fa', 'status_color', 'status_fa_text', 'created_at_fa', 'updated_at_fa'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusFaAttribute()
    {
        $html = '';

        if ($this->status == 'new') {
            $html = "<label class='badge badge-info'>". Lang::get('document status') ."<span> " .Lang::get('pending'). "</span ></label >";
        }
        if ($this->status == 'accept') {
            $html = "<label class='badge badge-success' >". Lang::get('document status') ."<span> " .Lang::get('confirmation'). "</span ></label >";
        }
        if ($this->status == 'failed') {
            $html = "<label class='badge badge-danger' >". Lang::get('document status') ."<span>" .Lang::get('failed'). "</span ></label >";
        }


        return $html;
    }

    public function getStatusFaTextAttribute()
    {
        $html = '';

        if ($this->status == 'new') {
            $html = Lang::get('document status is',['status' => Lang::get('pending')]);
        }
        if ($this->status == 'accept') {
            $html = Lang::get('document status is',['status' => Lang::get('confirmation')]);
        }
        if ($this->status == 'failed') {
            $html = Lang::get('document status is',['status' => Lang::get('failed')]);
        }


        return $html;
    }

    public function getStatusColorAttribute()
    {
        $html = '';

        if ($this->status == 'new') {
            $html = "blue";
        }
        if ($this->status == 'accept') {
            $html = "green";
        }
        if ($this->status == 'failed') {
            $html = "red";
        }


        return $html;
    }

    public function getCreatedAtFaAttribute()
    {
        $date = Jalalian::forge($this->created_at)->ago();

        return "<span class='badge badge-info btn-block'><i class='fa fa-clock-o'></i>$date</span >";
    }

    public function getUpdatedAtFaAttribute()
    {
        $date = Jalalian::forge($this->updated_at)->ago();

        return "<span class='badge badge-info btn-block'><i class='fa fa-clock-o'></i>$date</span >";
    }

}
