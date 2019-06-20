<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\Helpers;
use App\Utils\Validation;
use App\Utils\Email;
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
    private $email;
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
        $this->email = new Email();

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

    /**
     * Check if user credencial exists, if it does, send an email
     *
     * @param  \App\User   $user
     * @return array
     */

    public function forgotPassword(User $user)
    {
        try {
            $this->validate->validateForgotPassword($this->request);

            $db = getenv('DB_DATABASE');
            $user = DB::select('select * from ' . $db . ' where email = ?', [$this->request->input('email')]);

            if ($user) {
                $token = Helpers::jwt($user, $db);
                $result = $this->email->mailWithTemplate('RESET_PASSWORD',
                    $this->request->input('email'),
                    getenv('APP_URL')."/reset-password?token=$token&tstamp=".time()
                );
                return response()->json([
                    'success' => true,
                    'message' => 'An email with password reset instructions has been sent to your email address. It would expire in 1 hour.',
                    'status' => 200,
                    ], 200);
            }
            return response()->json([
                'error' => true,
                'message' => 'We could not find this email in our database.',
                'status' => 404,
                ], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong.']);
        }

    }

}
