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
     * Cara pakai di route:
     *   Route::middleware('role:admin')->group(...)
     *   Route::middleware('role:admin,guru')->group(...)  // boleh salah satu
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Anda harus login terlebih dahulu.'
            ], 401);
        }

        if (!in_array($user->role?->name, $roles)) {
            return response()->json([
                'status' => false,
                'message' => 'Anda tidak memiliki akses untuk melakukan aksi ini.'
            ], 403);
        }

        return $next($request);
    }
}