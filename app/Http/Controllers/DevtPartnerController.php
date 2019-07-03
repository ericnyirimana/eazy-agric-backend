<?php
namespace App\Http\Controllers;

use App\Models\DevtPartner;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class DevtPartnerController extends BaseController
{
    private $request;
    private $userData;

    /**
     * Offtaker constructor
     * @param object http request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = new Validation();
        $this->requestPassword = $this->request->input('password');
        $this->email = $this->request->input('email');

        $this->helpers = new Helpers();
    }

    /**
     * Get all development partners
     *
     * @return http response object
     */
    public function getDevtPartners()
    {
        $result = DevtPartner::all();
        return response()->json([
            'success' => true,
            'count' => count($result),
            'result' => $result,
        ], 200);
    }

    /**
     * Create development partner account
     * @return object http response
     */
    public function createDevtPartner()
    {
        try {
            $this->validate->validateNewAccount($this->request);

            $devtPartner = DevtPartner::create($this->request->all() + ['_id' => Helpers::generateId()]);
            if (!$devtPartner) {
                return response()->json([
                    'success' => false,
                    'error' => 'could not create user'], 408);
            }
            $sendEmail = $this->helpers->sendPassword($this->requestPassword, $this->email);

            return response()->json([
                'message' => 'Please check your mail for your login password',
                'success' => true,
                'devtPartner' => $devtPartner], 200);
        } catch (Exception $e) {
            return response()->json([
                'sucess' => 'false',
                'error' => 'Something went wrong'], 408);
        }
    }
}
