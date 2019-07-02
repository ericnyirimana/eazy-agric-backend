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
    private $password;
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
        $this->email = $this->request->input('email');
        $this->requestPassword = $this->request->input('password');
        $this->url = getenv('FRONTEND_URL');
        $this->mail = new Email();
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
            'result' => $result,
        ], 200);
    }
    /**
     * Create offtaker
     * @return object http response
     */
    public function createOfftaker()
    {
        try {
            $this->validate->validateNewAccount($this->request);
            $offtaker = OffTaker::create($this->request->all() + ['_id' => Helpers::generateId()]);

            if (!$offtaker) {
                return response()->json([
                    'success' => false,
                    'error' => 'Could not create user.'], 503);
            }

            $sendEmail = $this->helpers->sendPassword($this->requestPassword, $this->email);

            return response()->json([
                'message' => 'Please check your mail for your login password',
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
            $this->password = Helpers::generateId();
            $offtaker = OffTaker::create($this->request->all()
                 + Helpers::requestInfo($this->password));

            if (!$offtaker) {
                return response()->json([
                    'success' => false,
                    'error' => 'Could not create user.'], 408);
            }

            $sendEmail = $this->helpers->sendPassword($this->password, $this->email);

            return response()->json([
                'success' => true,
                'offtaker' => $offtaker], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.'], 408);
        }
    }
}
