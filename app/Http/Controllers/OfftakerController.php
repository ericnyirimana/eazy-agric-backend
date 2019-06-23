<?php
namespace App\Http\Controllers;

use App\Models\OffTaker;
use App\Utils\Email;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class OfftakerController extends BaseController
{
    private $request;
    private $userData;
    private $email;
    private $url;
    private $requestPassword;
    private $mail;
    private $message;

    /**
     * Offtaker constructor
     * @param object http request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = new Validation();
        $this->email = $request->input('email');
        $this->url = getenv('FRONTEND_URL');
        $this->helpers = new Helpers();

    }

    /**
     * Get all input suppliers
     *
     * @return http response object
     */
    public function getOfftakers()
    {
        $result = OffTaker::all();
        return response()->json([
            'success' => true,
            'count' => count($result),
            'offtakers' => $result,
        ], 200);
    }

    /**
     * Create offtaker
     * @return object http response
     */

    public function createOfftaker()
    {
        try {
            $this->validate->validateOfftaker($this->request);

            $offtaker = OffTaker::create($this->request->all() + ['_id' => Helpers::generateId()]);

            if (!$offtaker) {
                return response()->json([
                    'success' => false,
                    'error' => 'Could not create user.'], 503);
            }
            return response()->json([
                'success' => true,
                'offtaker' => $offtaker], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.'], 503);
        }
    }

    public function AccountRequest()
    {
        try {
            $this->validate->validateAccountRequest($this->request);

            $offtaker = OffTaker::create($this->request->all() + Helpers::requestInfo());
            if (!$offtaker) {
                return response()->json([
                    'success' => false,
                    'error' => 'Could not create user.'], 503);
            }
            $this->requestPassword = Helpers::getPassword();

<<<<<<< HEAD
            $sendEmail = $this->helpers->sendPassword($this->requestPassword, $this->email);
=======
            $sendEmail = $this->helpers->sendPassword($this->requestPassword);
>>>>>>> EW-148-story(user account): Fix user account

            return response()->json([
                'message' => 'Please check your mail for your login password',
                'success' => true,
                'offtaker' => $offtaker], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Something went wrong.'], 503);
        }
    }

}
