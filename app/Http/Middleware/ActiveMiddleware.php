<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ActiveMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->is_active == 0) {
            abort(403, 'Akun Anda Sedang Tidak Aktif');
        }

        return $next($request);
    }
}
