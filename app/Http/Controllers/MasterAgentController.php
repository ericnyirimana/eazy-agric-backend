<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\MasterAgent;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class MasterAgentController extends BaseController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = new Validation();
    }

    public function createMasterAgent()
    {
        try {
            $this->validate->validateMasterAgent($this->request);
            $user_id = $this->request->auth;

            $admin = Admin::where('_id', '=', $user_id)
                ->where('admin_role', 'Super Admin')->first();

            if (!$admin) {
                return response()->json(['success' => false, 'error' => 'You are not an authorized user.'], 403);
            }
            $masterAgent = MasterAgent::create($this->request->all() + ['_id' => Helpers::generateId()]);

            if (!$masterAgent) {
                return response()->json(['success' => false, 'error' => 'Could not create user.']);
            }
            return response()->json(['success' => true, 'masterAgent' => $masterAgent]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Something went wrong.']);
        }
    }
}
