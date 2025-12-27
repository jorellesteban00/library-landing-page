<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userRole = $request->user() ? strtolower(trim($request->user()->role)) : null;
        $allowedRoles = array_map(fn($r) => strtolower(trim($r)), $roles);

        if (!$userRole || !in_array($userRole, $allowedRoles)) {
            \Illuminate\Support\Facades\Log::info('Role Check Failed', [
                'user_role_raw' => $request->user() ? $request->user()->role : 'null',
                'user_role_processed' => $userRole,
                'allowed_roles_raw' => $roles,
                'allowed_roles_processed' => $allowedRoles,
                'user_id' => $request->user() ? $request->user()->id : 'null'
            ]);
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
