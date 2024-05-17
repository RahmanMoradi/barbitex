<?php

namespace App\Models\Webazin\Auth;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class AuthLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['created_at_fa'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getCreatedAtFaAttribute()
    {
        return Jalalian::forge($this->created_at)->format('Y-m-d H:m');
    }
}
