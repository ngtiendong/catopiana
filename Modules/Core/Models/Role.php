<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = ["name"];
    
    const ROLE_ACCOUNTING = 3;
    const ROLE_ADMIN = 4;
    const ROLE_SALE = 5;

    /**
     * The relationship
     */
    public function role_permissions()
    {
        return $this->hasMany('Modules\Core\Models\RolePermission', 'role_id');
    }

    public function saveListPermissions($permissions) {
        // Delete old records
        $this->role_permissions()->delete();
        // Insert new records
        $newObjs = [];
        foreach($permissions as $permission) {
            $obj = [
                'role_id' => $this->id,
                'permission_id' => $permission,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            array_push($newObjs, $obj);
        }
        RolePermission::insert($newObjs);
    }
    
    
    /**
     * Check role
     * @param $role_id
     * @return bool
     */
    public static function checkRole($role_id){
        $role_ids = RolePermission::getRoleHasPermissions(Auth::user()->getListPermissions());
        if(in_array($role_id, $role_ids)){
            return true;
        }
        return false;
    }
}
