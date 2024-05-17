<?php

namespace App\Models\Tournament;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
