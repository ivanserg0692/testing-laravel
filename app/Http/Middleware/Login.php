<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Login
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->submit === 'to-forgot-password') {
            return redirect()->route('password.forgot');
        }
        if ($request->submit === 'to-login') {
            return redirect()->route('login');
        }
        if($request->captcha) {
            $request->request->set('captcha', strtoupper($request->captcha));
        }
        return $next($request);
    }
}
