<?php


namespace App\Models\Webazin\Traits;



use App\Models\Webazin\Acl\Permission;
use App\Models\Webazin\Acl\Role;

trait Aclable
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function assignedRole(... $roles)
    {
        return $this->roles()->sync($roles);
    }

    public function unassignedRole()
    {
        $roles = $this->getAllRoles();
        return $this->roles()->detach($roles);
    }

    public function getAllRoles()
    {
        return Role::all();
    }

    public function givePermissionsTo(... $permissions)
    {
        $permissions = $this->getAllPermissions($permissions);

        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    public function withdrawPermissionsTo(... $permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    public function refreshPermissions(... $permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        if(is_string($role)) {
            return $this->roles->contains('name' , $role);
        }

        return !! $role->intersect($this->roles)->count();
    }

    public function hasRoles($roles)
    {
//        dd($roles);
        foreach($roles as $role) {
            if($this->hasRole($role))
                return true;
        }
        return false;
    }

    protected function hasPermission($permission)
    {
        return (bool)$this->permissions->where('name', $permission->name)->count();
    }

    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }
}
