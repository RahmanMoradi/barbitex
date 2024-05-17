<?php

namespace App\Models\Traid\Tron;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TronData extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public static function getMaster()
    {
        return TronData::where('is_master', true)->first();
    }

    public static function getUser($id)
    {
        return TronData::where('user_id', $id)->first();
    }

    public function setPrivateKeyAttribute($value)
    {
        $this->attributes['private_key'] = Helper::encrypt($value);
    }

    public function setPublicKeyAttribute($value)
    {
        $this->attributes['public_key'] = Helper::encrypt($value);
    }

    public function getPrivateKeyAttribute($value)
    {
        return Helper::decrypt($value);
    }

    public function getPublicKeyAttribute($value)
    {
        return Helper::decrypt($value);
    }
}
