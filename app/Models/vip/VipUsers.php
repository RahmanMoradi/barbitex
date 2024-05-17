<?php

namespace App\Models\vip;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipUsers extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['active'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function pack()
    {
        return $this->hasOne(VipPackage::class, 'id', 'package_id');
    }

    public function getActiveAttribute()
    {
        return $this->expire_at > Carbon::now();
    }
}
