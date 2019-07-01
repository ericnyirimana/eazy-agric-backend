<?php
namespace App\Http\Controllers;

use App\Models\MasterAgent;
use App\Utils\Email;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class MasterAgentController extends BaseController
{
    private $request;
    private $userData;
    private $email;
    private $url;
    private $requestPassword;
    private $password;
    private $mail;
    private $message;
    private $id;
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
     * Get all masteragents
     *
     * @return http response object
     */
    public function getMasterAgents()
    {
        $result = MasterAgent::all();
        return response()->json([
            'success' => true,
            'count' => count($result),
            'result' => $result,
        ], 200);
    }

    /**
     * Create master agent
     * @return object http response
     */

    public function createMasterAgent()
    {
        try {
            $this->validate->validateNewAccount($this->request);

            $masterAgent = MasterAgent::create($this->request->all() + ['_id' => Helpers::generateId()]);

            if (!$masterAgent) {
                return response()->json([
                    'success' => false,
                    'error' => 'Could not create user.'], 408);
            }

            $sendEmail = $this->helpers->sendPassword($this->password, $this->email);
            return response()->json([
                'message' => 'Please check your mail for your login password',
                'success' => true,
                'masterAgent' => $masterAgent], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.'], 408);
        }
    }

    public function AccountRequest()
    {
        try {
            $this->validate->validateAccountRequest($this->request);
            $this->password = Helpers::generateId();
            $masterAgent = MasterAgent::create($this->request->all()
                 + Helpers::requestInfo($this->password));

            if (!$masterAgent) {
                return response()->json([
                    'success' => false,
                    'error' => 'Could not create user.'], 408);
            }

            $sendEmail = $this->helpers->sendPassword($this->password, $this->email);

            return response()->json([
                'success' => true,
                'masterAgent' => $masterAgent], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.'], 408);
        }
    }

}
