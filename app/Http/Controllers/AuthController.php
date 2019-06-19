<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{/**
 * The request instance.
 *
 * @var \Illuminate\Http\Request
 */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = new Validation();

    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @param  \App\User   $user
     * @return mixed
     */

    public function authenticate(User $user)
    {
        try {
            $this->validate->validateLogin($this->request);

            $db = getenv('DB_DATABASE');
            $user = DB::select('select * from ' . $db . ' where email = ?', [$this->request->input('email')]);

            if (!$user) {
                return response()->json([
                    'success' => false, 'error' => 'The Email or password supplied is incorrect.'], 404);
            }
            // Verify the password and generate the token
            if (Hash::check($this->request->input('password'), $user[0][$db]['password'])) {
                $token = Helpers::jwt($user, $db);
                unset($user[0][$db]['password']);
                return response()->json(['success' => true, 'token' => $token, 'user' => $user[0][$db],
                ], 200);
            }
            return response()->json(['success' => false, 'error' => 'The Email or password supplied is incorrect.'], 404);
        } catch (Exception $e) {return response()->json(['error' => 'Something went wrong.']);
        }

    }

}
