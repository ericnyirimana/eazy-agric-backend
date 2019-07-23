<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\InputOrder;
use App\Models\MapCoordinate;
use App\Models\Planting;
use App\Models\SoilTest;
use App\Rules\ValidateInputFields;
use App\Services\SocialMedia;
use App\Utils\DateRequestFilter;
use App\Utils\Helpers;
use App\Utils\Validation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{
  private $request, $validate, $db, $validateInput;

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
    $this->validateInput = new ValidateInputFields($this->request->all());
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
        return Helpers::returnSuccess("", [
          'count' => count($result),
          'result' => $result,
        ], 200);
      }
    } catch (Exception $e) {
      return Helpers::returnError("Something went wrong.", 503);
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
          return $data ?
            Helpers::returnSuccess("", ['admin' => $data], 200) : Helpers::returnError("Could not create user.", 408);
        }
        return Helpers::returnError("Passwords do not match.", 401);
      } catch (Exception $err) {
        return Helpers::returnError("Something went wrong.", 503);
      }
    } catch (\Illuminate\Validate\ValidationException $e) {
      return Helpers::returnError($e->getMessage(), 422);
    }
  }

  public function getUser($id)
  {
    try {
      $user = Helpers::checkUser($id);
      if ($user) {
        return Helpers::returnSuccess("", ['user' => $user], 200);
      }
      return Helpers::returnError("User does not exist.", 404);
    } catch (Exception $e) {
      return Helpers::returnError("Something went wrong.", 503);
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
    return Helpers::returnSuccess("", [
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
  public function accountAction()
  {
    if (!preg_match('/\b(suspend|activate)\b/', $this->request->action)) {
      return Helpers::returnError("Invalid parameters supplied.", 400);
    }

    $action = ($this->request->action === 'activate') ? 'active' : 'suspended';

    try {
      if (Helpers::changeStatus($this->request->id, $action)) {
        $user = Helpers::queryUser($this->request->id);
        unset($user[0][$this->db]['password']);
        $message = ($action === 'active') ? 'Account activated successfully.' : 'Account suspended successfully.';
        return Helpers::returnSuccess($message, ['user' => $user[0][$this->db]], 200);
      } else {
        return Helpers::returnError("User not found.", 404);
      }
    } catch (Exception $e) {
      return Helpers::returnError("Something went wrong.", 503);
    }
  }

  /**
   * Returns twitter account number of followers and tweets
   */
  public function getTwitterReport()
  {
    try {
      $twitterReport = SocialMedia::getTwitterSummary();
      return Helpers::returnSuccess("", ['data' => $twitterReport], 200);
    } catch (\Exception $e) {
      return Helpers::returnError("Something went wrong", 503);
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
      return Helpers::returnSuccess("", ['data' => $statistics], 200);
    } catch (Exception $e) {
      return Helpers::returnError("Something went wrong", 503);
    }
  }

  /**
   * Returns facebook page likes and post shares count
   */
  public function getFacebookReport()
  {
    try {
      $facebookReport = SocialMedia::getFacebookSummary();
      return Helpers::returnSuccess("", ['data' => $facebookReport], 200);
    } catch (Exception $e) {
      return Helpers::returnError("Something went wrong", 503);
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
        return Helpers::returnSuccess("Your Password has been changed successfully.", [], 200);
      }
      return Helpers::returnError("Current password is incorrect.", 400);
    } catch (Exception $e) {
      return Helpers::returnError("Something went wrong.", 503);
    }
  }

  /**
   * Returns top performing master or village agents
   */

  public function getTopAgents()
  {
    if ($this->request->agent !== 'ma' && $this->request->agent !== 'va') {
      return Helpers::returnError("Invalid parameter supplied.", 400);
    }
    $field = ($this->request->agent === 'ma') ? 'ma_id' : 'vaId';
    try {
      $topAgents = [];
      $agentFarmerCount = DB::select("SELECT {$field}, COUNT(*) AS farmer_count FROM " . $this->db . "
                    WHERE type = 'farmer' GROUP BY {$field} ORDER BY farmer_count DESC LIMIT 5");
      foreach ($agentFarmerCount as $agent) {
        $topAgent = [];
        $topAgent['farmerCount'] = $agent['farmer_count'];
        $agentOrderCount = DB::select("SELECT COUNT({$field}) AS order_count FROM
                " . $this->db . " WHERE type = 'order' AND {$field}='" . $agent[$field] . "'");
        $topAgent['orderCount'] = $agentOrderCount[0]['order_count'];
        $agentName = ($this->request->agent === 'ma') ? DB::select("SELECT CONCAT(firstname, ' ', lastname) AS agent_name FROM
                " . $this->db . " WHERE type = '{$this->request->agent}'
                AND _id='" . $agent[$field] . "'") : DB::select("SELECT va_name AS agent_name FROM
                " . $this->db . " WHERE type = 'va' AND _id='" . $agent['vaId'] . "'");
        $topAgent['name'] = $agentName[0]['agent_name'];
        array_push($topAgents, $topAgent);
      }
      return Helpers::returnSuccess("", ['data' => $topAgents], 200);
    } catch (Exception $e) {
      return Helpers::returnError("Something went wrong.", 503);
    }
  }

  /** 
   * @param string id
   * @return object http response
   */
  public function deleteAccount($id)
  {
    try {
      $user = Helpers::checkUser($id);
      if (!$user) return Helpers::returnError("User does not exist.", 404);
      if (Helpers::deleteUser($id)) {
        return Helpers::returnSuccess("Account deleted successfully.", [], 200);
      } else return Helpers::returnError("Account could not be deleted.", 503);
    } catch (Exception $e) {
      return  Helpers::returnError("Something went wrong.", 503);
    }
  }

  /**
   * @param string id
   * @return object http response
   */

  public function editAccount($id)
  {
    $user = Helpers::checkUser($id);
    if (!$user) return Helpers::returnError("User does not exist.", 404);

    $isEmpty = $this->validateInput->isEmpty();
    if ($isEmpty) return Helpers::returnError($isEmpty, 422);

    $this->validate->validateExistingAccount($this->request, $id);

    try {
      if (Helpers::editAccount($id, $this->request->all())) {
        $updatedUser = Helpers::queryUser($id);
        unset($updatedUser[0][$this->db]['password']);
        return Helpers::returnSuccess("Account updated successfully.", ["user" => $updatedUser[0][$this->db]], 200);
      }
    } catch (\Illuminate\Validate\ValidationException $e) {
      return Helpers::returnError("Something went wrong.", 422);
    }
  }

  public function getUsers()
  {
    if (!preg_match('/\b(offtakers|village-agents|input-suppliers)\b/', $this->request->user)) {
      return Helpers::returnError("Invalid parameters supplied.", 400);
    }

    $model = [
      "offtakers" => "Offtaker",
      "village-agents" => "VillageAgent",
      "input-suppliers" => "InputSupplier"
    ];
    $model = 'App\Models\\' . $model[$this->request->user];

    $requestArray = DateRequestFilter::getRequestParam($this->request);
    list($start_date, $end_date) = $requestArray;

    $startDateCount = $model::where('created_at', '<=', $start_date)->get()->count();
    $endDateCount = $model::where('created_at', '<=', $end_date)->get()->count();
    $percentage = DateRequestFilter::getPercentage($startDateCount, $endDateCount);

    $result = $model::whereBetween('created_at', [$start_date, $end_date])->get();
    return Helpers::returnSuccess("", [
      'count' => count($result),
      'result' => $result,
      'percentage' => $percentage
    ], 200);
  }
}
