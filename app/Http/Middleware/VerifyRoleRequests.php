<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Lib\PermissionHelper;
use Nwidart\Modules\Facades\Module;

class VerifyRoleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (PermissionHelper::hasPermission('', '', $guard)) {
            return $next($request);
        } else {
            return redirect('/admin');
        }
    }
}
