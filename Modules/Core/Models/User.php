<?php

namespace Modules\Core\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Carbon\Carbon;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use SoftDeletes, Authenticatable, CanResetPassword;

    protected $fillable = ["username", "email", "password", "fullname", "phone"];

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    /**
     * The relationship
     */
    public function user_roles()
    {
        return $this->hasMany('Modules\Core\Models\UserRole', 'user_id');
    }
    public function roles()
    {
        return $this->hasManyThrough(
            'Modules\Core\Models\Role','Modules\Core\Models\UserRole',
            'user_id', 'id'
        );
    }
    public function user_groups()
    {
        return $this->hasMany('Modules\Core\Models\UserGroup', 'user_id');
    }
    public function groups()
    {
        return $this->hasManyThrough(
            'Modules\Core\Models\Group','Modules\Core\Models\UserGroup',
            'user_id', 'id'
        );
    }

    public function getListPermissions() {
        $roleIds = $this->user_roles->pluck("role_id")->toArray();
        $userPermissions = RolePermission::whereIn("role_id", $roleIds)->groupBy("permission_id")->pluck("permission_id")->toArray();
        return $userPermissions;
    }

    public function hasPermission($controller, $action) {
        $scorePermission = Permission::getRequestPermissionScore($controller, $action);
        //\Debugbar::info($scorePermission);
        if ($scorePermission != null) {
            $userPermissions = $this->getListPermissions();
            //\Debugbar::info($userPermissions);
            return in_array($scorePermission, $userPermissions);
        }
        // No need check permission
        return true;
    }

    public function saveListRoles($roles) {
        // Delete old records
        $this->user_roles()->delete();
        // Insert new records
        $newObjs = [];
        foreach($roles as $role) {
            $obj = [
                'user_id' => $this->id,
                'role_id' => $role,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            array_push($newObjs, $obj);
        }
        UserRole::insert($newObjs);
    }

    public function saveListGroups($groups) {
        // Delete old records
        $this->user_groups()->delete();
        // Insert new records
        $newObjs = [];
        foreach($groups as $group) {
            $obj = [
                'user_id' => $this->id,
                'group_id' => $group,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            array_push($newObjs, $obj);
        }
        UserGroup::insert($newObjs);
    }

    /**
     * Get user avatar
     * @return string
     */
    public static function getUserAvatar(){
        $user = auth()->user();
        $avatar = $user->avatar;
        if ($user->sex == 0) {
            $customerAvatar = asset('/img/icon_female.png');
        } else {
            $customerAvatar = asset('/img/icon_male.png');
        }
        if (!empty($avatar)) {
            $avatarArray = json_decode($avatar, true);
            $customerAvatar = $avatarArray['medium_url'];
        }

        return $customerAvatar;
    }
}
