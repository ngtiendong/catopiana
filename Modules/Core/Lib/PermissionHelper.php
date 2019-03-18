<?php

namespace Modules\Core\Lib;

use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\Permission;

class PermissionHelper
{
    /**
     * @param $action
     * @param string $controller
     * @param null $guard
     * @return bool
     */
    public static function hasPermission($action = '', $controller = '', $guard = null)
    {
        // Get current controller
        $route = request()->route();
        $currentAction = $route->getActionName();
        list($currController, $currAction) = explode('@', $currentAction);

        if (empty($controller)) {
            $controller = $currController;
        }

        if (empty($action)) {
            $action = $currAction;
        }

        // Check permission for current user
        $scorePermission = Permission::getRequestPermissionScore($controller, $action);

        if ($scorePermission != null) {
            // Check by current user
            $user = Auth::user($guard);

            if ($user->id != 1) {
                // No permission access => redirect to home page
                $hasPermission = $user->hasPermission($controller, $action);
                if (!$hasPermission) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Check current user is administrator or not
     *
     * @return bool
     */
    public static function isAdmin()
    {
        $user = Auth::user();

        $userRoles = $user->user_roles;

        if ($userRoles) {
            foreach ($userRoles as $userRole) {
                if ($userRole->role->is_master == 1) {
                    return true;
                }
            }
        }

        return false;
    }
}