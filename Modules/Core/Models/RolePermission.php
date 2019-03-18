<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = ["role_id", "permission_id"];

    /**
     * The relationship
     */
    public function role()
    {
        return $this->belongsTo('Modules\Core\Models\Role', 'role_id');
    }

    /**
     * @param $permissionIds
     * @return \Illuminate\Support\Collection
     */
    public static function getRoleHasPermissions($permissionIds)
    {
        return self::whereIn('permission_id', $permissionIds)->select('role_id')->get()->pluck('role_id')->toArray();
    }
}
