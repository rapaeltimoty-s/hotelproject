<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            // belum login
            return redirect()->route('login')->with('status', 'Silakan login.');
        }

        if ($user->role !== 'admin') {
            // sudah login tapi bukan admin
            return redirect()->route('home')->with('status', 'Akses khusus admin.');
        }

        return $next($request);
    }
}
