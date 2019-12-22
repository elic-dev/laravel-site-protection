<?php

namespace ElicDev\SiteProtection\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Arr;

class SiteProtection
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $password = config('site-protection.passwords');
        $configProtectedPaths = config('site-protection.protected_paths');
        if ($configProtectedPaths !== false) {
            $protectedPaths = explode(',', $configProtectedPaths);

            if (!in_array($request->path(), $protectedPaths)) {
                return $next($request);
            }
        }

        if (empty($password)) {
            return $next($request);
        }

        $passwords = explode(',', $password);

        if (in_array($request->get('site-password-protected'), $passwords)) {
            setcookie('site-password-protected', encrypt($request->get('site-password-protected')), 0, '/');
            return redirect($request->url());
        }

        try {
            $usersPassword = decrypt(Arr::get($_COOKIE, 'site-password-protected'));
            if (in_array($usersPassword, $passwords)) {
                return $next($request);
            }
        } catch (DecryptException $e) {
            // empty value in cookie
        }

        return response(view('site-protection::site-protection-form'), 403);
    }
}
