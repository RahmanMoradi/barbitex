<?php

namespace App\Models\Webazin\Acl;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'label'];

    /*<relation>*/
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    /*</relation>*/
}
