<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    private $request;
    private $validate;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = new Validation();

    }

    public function createAdmin()
    {
        try {
            $this->validate->validateAdmin($this->request);
            if ($this->request->password === $this->request->confirmPassword) {
                $user_id = $this->request->auth;
                $admin = Admin::where('_id', '=', $user_id)
                    ->where('admin_role', 'Super Admin')->first();

                if (!$admin) {
                    return response()->json(['error' => 'You are not an authorized user.'], 403);
                }

                $data = Admin::create($this->request->all() + ['_id' => Helpers::generateId()]);

                return $data ? response()->json(['success' => true, 'admin' => $data]) :
                response()->json(['success' => false, 'error' => 'Could not create user.']);
            }
            return response()->json(['error' => 'Passwords does not match.']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong.']);
        }
    }
}
