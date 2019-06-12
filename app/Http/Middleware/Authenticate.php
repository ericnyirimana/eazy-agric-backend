<?php
namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
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
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['error' => 'Please log in first.'], 401);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);

        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Your current session has expired, please log in again.'], 400);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occured while decoding token.'], 400);
        }
        //Get subscriber
        $user = $credentials->sub;
        if ($user) {
            $request->auth = $user;
        }
        response()->json(['error' => 'Invalid token. Please log in again.'], 400);
        return $next($request);
    }
}
