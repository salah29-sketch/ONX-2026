<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!app()->runningInConsole() && $user) {
            $permissionsArray = Cache::remember('auth_gates_permissions', 3600, function () {
                $roles = Role::with('permissions:id,title')->get();
                $map   = [];

                foreach ($roles as $role) {
                    foreach ($role->permissions as $permission) {
                        $map[$permission->title][] = $role->id;
                    }
                }

                return $map;
            });

            foreach ($permissionsArray as $title => $roleIds) {
                Gate::define($title, function (\App\Models\User $user) use ($roleIds) {
                    return count(array_intersect($user->roles->pluck('id')->toArray(), $roleIds)) > 0;
                });
            }
        }

        return $next($request);
    }
}
