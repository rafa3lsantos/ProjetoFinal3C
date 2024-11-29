<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UniqueEmailMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $email = $request->input('email');

        if (
            DB::table('candidates')->where('email', $email)->exists() ||
            DB::table('companies')->where('email', $email)->exists() ||
            DB::table('recruiters')->where('email', $email)->exists()
        ) {
            return response()->json([
                'message' => 'O e-mail já está em uso.',
            ], 422); 
        }

        return $next($request);
    }
}
