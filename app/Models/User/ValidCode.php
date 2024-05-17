<?php

namespace App\Models\User;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class ValidCode extends Model
{
    protected $guarded = ['id'];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = Helper::encrypt($value);
    }

    public function getCodeAttribute($value)
    {
        return Helper::decrypt($value);
    }
}
