<?php

namespace App\Models\Admin;

use App\Models\Webazin\Fcm\Fcm;
use App\Models\Webazin\Traits\Aclable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, Aclable;

    protected $guard = 'admin';
    protected $guarded = ['id'];

    public function fcms()
    {
        return $this->hasMany(Fcm::class, 'user_id', 'id');
    }
}
