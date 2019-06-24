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
        $this->email = $request->input('email');
        $this->url = getenv('FRONTEND_URL');
        $this->mail = new Email();
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
            $this->validate->validateMasterAgent($this->request);

            $masterAgent = MasterAgent::create($this->request->all() + ['_id' => Helpers::generateId()]);

            if (!$masterAgent) {
                return response()->json([
                    'success' => false,
                    'error' => 'Could not create user.'], 408);
            }
            return response()->json([
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

            $masterAgent = MasterAgent::create($this->request->all());

            if (!$masterAgent) {
                return response()->json([
                    'success' => false,
                    'error' => 'Could not create user.'], 408);
            }
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
