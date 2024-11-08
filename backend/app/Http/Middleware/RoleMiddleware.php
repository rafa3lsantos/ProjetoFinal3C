<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Corrigido para usar a facade Auth
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

use function PHPSTORM_META\type;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        if (strtolower(class_basename(Auth::user())) !== $role) {
            return response()->json(['message' => 'Você não tem permissão para realizar esta ação'], 401);
        }

        return $next($request);
    }
}
