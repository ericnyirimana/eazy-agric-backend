<?php
namespace App\Http\Middleware;

use Closure;
use App\Utils\Helpers;


class ValidateParams
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
      if (!preg_match('/\b(masteragent|offtaker)\b/', $request->user)) {
        return Helpers::returnError("Invalid parameter supplied.", 400);
      }
        return $next($request);
    }
}
