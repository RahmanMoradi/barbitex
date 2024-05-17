<?php

namespace App\Models\Webazin\Acl;

use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'label'];

    /*<relation>*/
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(Admin::class);
    }
    /*</relation>*/
}
