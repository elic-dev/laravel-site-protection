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

        if (empty($password) ||
            $this->inExceptArray($request) ||
            $this->isNotInProtectedOnlyPath($request)) {
            return $next($request);
        }

        $passwords = explode(',', $password);

        if (in_array($request->get('site-password-protected'), $passwords)) {
            setcookie('site-password-protected', encrypt($request->get('site-password-protected')), time() + config('site-protection.cookie_lifetime'), '/');
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

    /**
     * Determine if the request has a URI is only protect.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function isNotInProtectedOnlyPath($request)
    {
        $protectOnlyPaths = config('site-protection.protected_only_paths');

        if (empty($protectOnlyPaths)) {
            return false;
        }

        if (is_string($protectOnlyPaths)) {
            $protectOnlyPaths = explode(',', $protectOnlyPaths);
        }

        foreach ($protectOnlyPaths as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return false;
            }
        }

        return true;
    }


    /**
     * Determine if the request has a URI that should pass through SiteProtection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        $exceptedPaths = config('site-protection.except_paths');

        if (empty($exceptedPaths)) {
            return false;
        }

        if (is_string($exceptedPaths)) {
            $exceptedPaths = explode(',', $exceptedPaths);
        }

        foreach ($exceptedPaths as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
