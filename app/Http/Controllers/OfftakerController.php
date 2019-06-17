<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\OffTaker;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class OfftakerController extends BaseController
{
    private $request;
    private $userData;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->validate = new Validation();
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

    public function createOfftaker()
    {
        try {
            $this->validate->validateOfftaker($this->request);
            $user_id = $this->request->auth;
            $admin = Admin::where('_id', '=', $user_id)
                ->where('admin_role', 'Super Admin')->first();
            if (!$admin) {
                return response()->json(['error' => 'You are not an authorized user.'], 403);
            }

            $offtaker = OffTaker::create($this->request->all() + ['_id' => Helpers::generateId()]);

            if (!$offtaker) {
                return response()->json(['success' => false, 'error' => 'Could not create user.']);
            }
            return response()->json(['success' => true, 'offtaker' => $offtaker]);
        } catch (Exception $e) {
            return response()->json(["error" => 'Something went wrong.']);
        }
    }
}
