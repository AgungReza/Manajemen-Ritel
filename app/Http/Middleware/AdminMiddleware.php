<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login, arahkan ke halaman login.
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Jika sudah login tetapi bukan admin.
        if ($request->user()->role !== 'admin') {
            return response()->view(
                'errors.unauthorized',
                [
                    'redirectUrl' => route('dashboard'),
                    'countdown' => 5,
                ],
                403
            );
        }

        return $next($request);
    }
}
