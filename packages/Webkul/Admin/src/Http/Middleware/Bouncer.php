<?php

namespace Webkul\Admin\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class Bouncer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, \Closure $next, $guard = 'user')
    {
        if (! auth()->guard($guard)->check()) {
            return redirect()->route('admin.session.create');
        }

        /**
         * If user status is changed by admin. Then session should be
         * logged out.
         */
        if (! (bool) auth()->guard($guard)->user()->status) {
            auth()->guard($guard)->logout();

            session()->flash('error', __('admin::app.errors.401'));

            return redirect()->route('admin.session.create');
        }

        /**
         * If somehow the user deleted all permissions, then it should be
         * auto logged out and need to contact the administrator again.
         */
        if ($this->isPermissionsEmpty()) {
            auth()->guard($guard)->logout();

            session()->flash('error', __('admin::app.errors.401'));

            return redirect()->route('admin.session.create');
        }

        $canAccess = $this->checkPermissions($request);

        View::share('canAccess', $canAccess); // Compartilha a variável com as views

                
        return $next($request);
    }

    protected function checkPermissions($request)
    {
        $user = auth()->guard('user')->user();
        $routeName = Route::currentRouteName(); // Nome completo da rota atual
    
        $cleanRouteName = $this->sanitizeRouteName($routeName);

        $role = $user->role;
    
        if ($role->permission_type === 'all') {
            return true;
        }
    
        $permissions = $role->permissions ?? [];

        if (in_array($cleanRouteName, $permissions)) {
            return true;
        }
    
        $module = $this->extractModuleName($cleanRouteName);
        if (in_array($module, $permissions)) {
            return true; 
        }
    
        return false;
    }

    protected function sanitizeRouteName($routeName)
    {
        if (str_starts_with($routeName, 'admin.')) {
            $routeName = substr($routeName, strlen('admin.'));
        }
    
        if (str_ends_with($routeName, '.index')) {
            $routeName = substr($routeName, 0, -strlen('.index'));
        }
    
        return $routeName;
    }
    
    protected function extractModuleName($cleanRouteName)
    {
        return explode('.', $cleanRouteName)[0];
    }

    /**
     * Check if user permissions are empty except for admin.
     *
     * @return bool
     */
    public function isPermissionsEmpty()
    {
        $user = auth()->guard('user')->user();
        $role = $user->role;

        if (!$role) {
            return true;
        }

        if ($role->permission_type === 'all') {
            return false;
        }

        return empty($role->permissions);
    }
    
    // /**
    //  * Check for user, if they have empty permissions or not except admin.
    //  *
    //  * @return bool
    //  */
    // public function isPermissionsEmpty()
    // {
    //     if (! $role = auth()->guard('user')->user()->role) {
    //         abort(401, 'This action is unauthorized.');
    //     }

    //     if ($role->permission_type === 'all') {
    //         return false;
    //     }

    //     if ($role->permission_type !== 'all' && empty($role->permissions)) {
    //         return true;
    //     }

    //     $this->checkIfAuthorized();

    //     return false;
    // }

    /**
     * Check authorization.
     *
     * @return null
     */
    public function checkIfAuthorized()
    {
        $roles = acl()->getRoles();

        if (isset($roles[Route::currentRouteName()])) {
            bouncer()->allow($roles[Route::currentRouteName()]);
        }
    }
}
