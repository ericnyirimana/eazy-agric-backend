<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\InputOrder;
use App\Models\Planting;
use App\Models\SoilTest;
use App\Models\MapCoordinate;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    private $request;
    private $validate;

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
     * Create Admin Account
     * @return object http response
     */
    public function createAdmin()
    {
        try {
            $this->validate->validateAdmin($this->request);
            if ($this->request->password === $this->request->confirmPassword) {

                $data = Admin::create($this->request->all() + ['_id' => Helpers::generateId()]);

                return $data ? response()->json([
                    'success' => true,
                    'admin' => $data], 200) :
                response()->json([
                    'success' => false,
                    'error' => 'Could not create user.'], 408);
            }
            return response()->json([
                'success' => false,
                'error' => 'Passwords does not match.'], 401);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.'], 408);
        }
    }

    public function getActivitySummary()
    {
        $inputOrders = InputOrder::pluck('details')->toArray();
        $acresPlanted = Planting::pluck('acreage')->toArray();
        $soilTestAcreage = SoilTest::pluck('acreage')->toArray();
        $gardenMapped = MapCoordinate::pluck('acreage')->toArray();
        return response()->json([
            'success' => true,
            'inputOrders' => array_sum(array_column($inputOrders, 'totalCost')),
            'acresPlanted' => array_sum($acresPlanted),
            'soilTestAcreage' => array_sum($soilTestAcreage),
            'gardenMapped' => array_sum($gardenMapped)
        ], 200);
    }
}
