<?php

namespace ElicDev\SiteProtection\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;

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
        $skipEnvironment = config('site-protection.skip_environments');

        if (empty($password)) {
            return $next($request);
        }

        $passwords = explode(',', $password);
        $skipEnvironments = explode(',', $skipEnvironment);

        if (in_array(\App::environment(), $skipEnvironments)) {
            return $next($request);
        }

        if (in_array($request->get('site-password-protected'), $passwords)) {
            setcookie('site-password-protected', encrypt($request->get('site-password-protected')), 0, '/');
            return redirect($request->url());
        }

        try {
            $usersPassword = decrypt(array_get($_COOKIE, 'site-password-protected'));
            if (in_array($usersPassword, $passwords)) {
                return $next($request);
            }
        } catch (DecryptException $e) {
            // empty value in cookie
        }

        return response(view('site-protection::site-protection-form'), 403);
    }
}
