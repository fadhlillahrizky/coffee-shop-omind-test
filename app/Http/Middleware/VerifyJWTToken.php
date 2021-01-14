<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $token = $request->header('authorization');
            $user = JWTAuth::parseToken()->authenticate();

            if ($user === false) {
                return error(401, 'Token tidak valid. Silahkan login kembali.', '01');
            }

            // check banned users
            if (!empty($user->banner) && $user->banned) {
                JWTAuth::invalidate($token);
                return error(401, __('messages.authorizations.ccount_banned', ['reason' => $user->ban_reason]), '03');
            }

        } catch (JWTException $e) {

            if ($e instanceof TokenExpiredException) {
                return error(401, 'Sesi login anda sudah kadaluarsa, silahkan login kembali.');
            }

            if ($e instanceof TokenInvalidException) {
                return error(401, 'Silahkan cek koneksi anda. Coba login kembali.');
            }

            return error(401, 'Silahkan login.');
        }

        return $next($request);
    }
}
