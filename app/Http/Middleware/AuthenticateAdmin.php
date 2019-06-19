<?php
namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;

class AuthenticateAdmin
{
    private $user_id;
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->user_id = $this->request->auth;
    }
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
        $user_id = $this->request->auth;
        $admin = Admin::where('_id', '=', $user_id)
            ->where('adminRole', 'Super Admin')->first();

        if (!$admin) {
            return response()->json([
                'success' => false,
                'error' => 'You are not an authorized user.'], 403);
        }
        return $next($request);
    }
}
