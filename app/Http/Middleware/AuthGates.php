<?php

namespace App\Http\Middleware;

use App\Models\Admin\Role;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!app()->runningInConsole() && $user) {
            // صاحب الموقع: كامل الصلاحيات دائماً (بالبريد من .env أو المستخدم الأول)
            Gate::before(function ($user, $ability) {
                if ($this->isSiteOwner($user)) {
                    return true;
                }
                return null;
            });

            $roles            = Role::with('permissions')->get();
            $permissionsArray = [];

            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    $permissionsArray[$permissions->title][] = $role->id;
                }
            }

            foreach ($permissionsArray as $title => $roles) {
                Gate::define($title, function (\App\Models\User $user) use ($roles) {
                    return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
                });
            }
        }

        return $next($request);
    }

    /**
     * هل هذا المستخدم صاحب الموقع (له كامل الصلاحيات)؟
     * يُحدد عبر: APP_OWNER_EMAIL في .env أو المستخدم رقم 1
     */
    protected function isSiteOwner($user): bool
    {
        $ownerEmail = config('app.owner_email');
        if ($ownerEmail && $user->email && strcasecmp($user->email, $ownerEmail) === 0) {
            return true;
        }
        return $user->id === 1;
    }
}
