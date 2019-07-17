<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\InputOrder;
use App\Models\MapCoordinate;
use App\Models\Planting;
use App\Models\SoilTest;
use App\Services\SocialMedia;
use App\Utils\Helpers;
use App\Utils\Validation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Utils\DateRequestFilter;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{
    private $request;
    private $validate;
    private $db;

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
        $this->db = getenv('DB_DATABASE');
        $this->helpers = new Helpers();

    }
    /**
     * Get all admins
     * @return object http response
     */

    public function getAdmins()
    {
        try {
            $result = Admin::all();
            if ($result) {
                return response()->json([
                    'success' => true,
                    'count' => count($result),
                    'result' => $result,
                ], 200);
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong.',
            ], 503);
        }
    }

    /**
     * Create Admin Account
     * @return object http response
     */
    public function createAdmin()
    {
        try {
            $this->validate->validateAdmin($this->request);
            try {
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
                    'error' => 'Passwords do not match.'], 401);
            } catch (Exception $err) {
                return response()->json([
                    'success' => false,
                    'error' => 'Something went wrong.'], 503);
            }
        } catch (\Illuminate\Validate\ValidationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()], 422);
        }
    }

    public function getActivitySummary(Request $request)
    {
        $requestArray = DateRequestFilter::getRequestParam($request);
        list($start_date, $end_date) = $requestArray;


        $oldInputOrdersSum = InputOrder::where('created_at', '<=', $start_date)->sum('details.totalCost');
        $oldInputAcresPlanted = Planting::where('created_at', '<=', $start_date)->pluck('acreage')->toArray();
        $oldInputSoilTestAcreage = SoilTest::where('created_at', '<=', $start_date)->pluck('acreage')->toArray();
        $oldInputGardenMapped = MapCoordinate::where('created_at', '<=', $start_date)->sum('acreage');

        $newInputOrdersSum = InputOrder::where('created_at', '<=', $end_date)->sum('details.totalCost');
        $newInputAcresPlanted = Planting::where('created_at', '<=', $end_date)->pluck('acreage')->toArray();
        $newInputSoilTestAcreage = SoilTest::where('created_at', '<=', $end_date)->pluck('acreage')->toArray();
        $newInputGardenMapped = MapCoordinate::where('created_at', '<=', $end_date)->sum('acreage');
        
       
       $percentageInputOrders = DateRequestFilter::getPercentage($oldInputOrdersSum, $newInputOrdersSum);
       $percentageAcresPlanted = DateRequestFilter::getPercentage(array_sum($oldInputAcresPlanted), array_sum($newInputAcresPlanted));
       $percentageSoilTestAcreage = DateRequestFilter::getPercentage(array_sum($oldInputSoilTestAcreage), array_sum($newInputSoilTestAcreage));
       $percentageGardenMapped = DateRequestFilter::getPercentage($oldInputGardenMapped, $newInputGardenMapped);

        $inputOrders = InputOrder::whereBetween('created_at', [$start_date, $end_date])->pluck('details')->toArray();
        $acresPlanted = Planting::whereBetween('created_at', [$start_date, $end_date])->pluck('acreage')->toArray();
        $soilTestAcreage = SoilTest::whereBetween('created_at', [$start_date, $end_date])->pluck('acreage')->toArray();
        $gardenMapped = MapCoordinate::whereBetween('created_at', [$start_date, $end_date])->pluck('acreage')->toArray();
        return response()->json([
            'success' => true,
            'activities' => [
                'Input orders' => array_sum(array_column($inputOrders, 'totalCost')),
                'Planting' => array_sum($acresPlanted) . ' Acres',
                'Soil testing' => array_sum($soilTestAcreage) . ' Acres',
                'Garden Mapping' => array_sum($gardenMapped) . ' Acres',
                'Produce Sold' => 0 . ' Tons',
            ],
            'activitiesPercentage' => [
                'Input orders' => $percentageInputOrders,
                'Planting' => $percentageAcresPlanted,
                'Soil testing' => $percentageSoilTestAcreage,
                'Garden Mapping' => $percentageGardenMapped,
                'Produce Sold' => 0,
            ]
        ], 200);
    }

    /**
     * Activate user account
     * @param string $id
     * @return object http response
     */
    public function activateAccount($id)
    {
        try {
            if (Helpers::changeStatus($id, 'active')) {
                $user = Helpers::queryUser($id);
                unset($user[0][$this->db]['password']);
                return response()->json([
                    'success' => true,
                    'message' => 'Account activated successfully.',
                    'user' => $user[0][$this->db],
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.',
            ], 503);
        }

    }

    /**
     * Suspend account
     * @param string $id
     * @return object http response
     */
    public function suspendAccount($id)
    {
        try {
            if (Helpers::changeStatus($id, 'suspended')) {
                $user = Helpers::queryUser($id);
                unset($user[0][$this->db]['password']);
                return response()->json([
                    'success' => true,
                    'message' => 'Account suspended successfully.',
                    'user' => $user[0][$this->db],
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.',
            ], 503);
        }

    }

    /**
     * Returns twitter account number of followers and tweets
     */
    public function getTwitterReport()
    {
        try {
            $twitterReport = SocialMedia::getTwitterSummary();
            return response()->json([
                'success' => true,
                'data' => $twitterReport,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 503);
        }
    }

    /**
     * Returns Youtube report
     */
    public function getYoutubeReport()
    {
        try {
            $youtubeChannelSummary = SocialMedia::getYoutubeSummary();
            $statistics = $youtubeChannelSummary->items[0]->statistics;
            return response()->json([
                'success' => true,
                'data' => $statistics,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 503);
        }
    }

    /**
     * Returns facebook page likes and post shares count
     */
    public function getFacebookReport()
    {
        try {
            $facebookReport = SocialMedia::getFacebookSummary();
            return response()->json([
                'success' => true,
                'data' => $facebookReport,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 503);
        }
    }

    /**
     * Check if user credencial exists, if it does, send an email
     *
     * @param  \App\User   $user
     * @return array
     */

    public function changePassword(Admin $admin)
    {
        try {
            $this->validate->validateAdminChangePassword($this->request);
            $user = DB::select('select * from ' . $this->db . ' where _id = ?', [$this->request->auth]);
            if (Hash::check($this->request->input('oldPassword'), $user[0][$this->db]['password'])) {
                Admin::where('_id', $this->request->auth)->update(['password' => Hash::make($this->request->input('newPassword'))]);
                return response()->json([
                    'success' => true,
                    'message' => 'Your Password has been changed successfully.'], 200);
            }
            return response()->json([ 'success' => false,
                'message' => 'Current password is incorrect.',], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong.']);
        }
    }

    /**
     * Returns top performing master agents
     */
    public function getTopMasterAgents()
    {
        try {
            $topMasterAgents = [];
            $masterAgentFarmerCount = DB::select("SELECT ma_id, COUNT(*) AS farmer_count 
                    FROM " . $this->db . "
                    WHERE type = 'farmer'
                    GROUP BY ma_id
                    ORDER BY farmer_count 
                    DESC LIMIT 5");
            foreach ($masterAgentFarmerCount as $masterAgent) {
                $topMasterAgent = [];
                $topMasterAgent['farmerCount'] = $masterAgent['farmer_count'];

                $masterAgentOrderCount = DB::select("SELECT COUNT(ma_id) AS order_count FROM
                " . $this->db . " 
                WHERE type = 'order'
                AND ma_id='" . $masterAgent['ma_id'] . "'");
                $topMasterAgent['orderCount'] = $masterAgentOrderCount[0]['order_count'];

                $masterAgentName = DB::select("SELECT CONCAT(firstname, ' ', lastname) AS master_agent_name FROM
                " . $this->db . " 
                WHERE type = 'ma'
                AND _id='" . $masterAgent['ma_id'] . "'");
                $topMasterAgent['name'] = $masterAgentName[0]['master_agent_name'];
                array_push($topMasterAgents, $topMasterAgent);
            }
            return response()->json([
                'success' => true,
                'data' => $topMasterAgents,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 503);
        }
    }

    /**
     * Returns top performing village agents
     */
    public function getTopVillageAgents()
    {
        try {
            $topVillageAgents = [];
            $villageAgentFarmerCount = DB::select("SELECT vaId, COUNT(*) AS farmer_count 
                    FROM " . $this->db . "
                    WHERE type = 'farmer'
                    GROUP BY vaId
                    ORDER BY farmer_count 
                    DESC LIMIT 5");
            foreach ($villageAgentFarmerCount as $villageAgent) {
                $topVillageAgent = [];
                $topVillageAgent['farmerCount'] = $villageAgent['farmer_count'];

                $villageAgentOrderCount = DB::select("SELECT COUNT(vaId) AS order_count FROM
                " . $this->db . " 
                WHERE type = 'order'
                AND vaId='" . $villageAgent['vaId'] . "'");
                $topVillageAgent['orderCount'] = $villageAgentOrderCount[0]['order_count'];

                $villageAgentName = DB::select("SELECT va_name AS village_agent_name FROM
                " . $this->db . " 
                WHERE type = 'va'
                AND _id='" . $villageAgent['vaId'] . "'");

                $topVillageAgent['name'] = $villageAgentName[0]['village_agent_name'];
                array_push($topVillageAgents, $topVillageAgent);
            }
            return response()->json([
                'success' => true,
                'data' => $topVillageAgents,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ], 503);
        }
    }
}
