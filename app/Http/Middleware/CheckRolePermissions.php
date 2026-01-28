<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRolePermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();

        if (! $routeName) {
            // No route name, cannot check permissions automatically
            return $next($request);
        }

        // Logic to parse namespace/module/action from route name
        // Convention: [namespace.]module.action. OR just module.action.
        // We will use the FULL route name as the 'check namespace' for strict matching if configured.
        $parts = explode('.', $routeName);

        $action = array_pop($parts);
        $module = array_pop($parts);
        $namespace = $routeName; // Use full name as namespace key as requested

        if (!$module || !$action) {
            return $next($request);
        }

        // Action Map removed: Route names now match privilege actions directly.
        $checkAction = $action;

        /** @var User $user */
        $user = $request->user();

        if (! $user || ! $user->hasPrivilege($module, $checkAction, $namespace)) {
            abort(403, "dont have access to {$routeName}");
        }

        return $next($request);
    }
}
