<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\InputOrder;
use App\Models\MapCoordinate;
use App\Models\Planting;
use App\Models\SoilTest;
use App\Rules\ValidateInputFields;
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
          $userInfo = [
              'email' => $this->request->admin->email,
              'target_firstname' => $data->firstname,
              'target_lastname' => $data->lastname,
              'target_email' => $data->email
          ];
          $activityLog =  $data ? Helpers::logActivity($userInfo, 'admin account created') : [];

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

        Helpers::logActivity(
            [
                'email' => $this->request->admin->email,
                'target_firstname' => $user[0][$this->db]['firstname'],
                'target_lastname' => $user[0][$this->db]['lastname'],
                'target_email' => $user[0][$this->db]['email'],
            ],
            str_replace(' successfully', '', $message));

        return Helpers::returnSuccess($message, ['user' => $user[0][$this->db]], 200);
      } else {
        return Helpers::returnError("User not found.", 404);
      }
    } catch (Exception $e) {
      return Helpers::returnError("Something went wrong.", 503);
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
        Helpers::logActivity([
            'target_firstname' => $user[0][$this->db]['firstname'], 'email' => $this->request->admin->email,
            'target_email' => $user[0][$this->db]['email'], 'target_lastname' => $user[0][$this->db]['lastname'],
        ], 'password changed.');

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
        Helpers::logActivity([
            'email' => $this->request->admin->email,
            'target_firstname' => $user['firstname'],
            'target_lastname' => $user['lastname'],
            'target_email' => $user['email'],
        ], 'Account deleted');
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

        Helpers::logActivity([
            'email' => $this->request->admin->email, 'target_firstname' => $updatedUser[0][$this->db]['firstname'],
            'target_email' => $updatedUser[0][$this->db]['email'],
            'target_lastname' => $updatedUser[0][$this->db]['lastname']
        ], 'account updated');
        return Helpers::returnSuccess("Account updated successfully.", ["user" => $updatedUser[0][$this->db]], 200);
      }
    } catch (\Illuminate\Validate\ValidationException $e) {
      return Helpers::returnError("Something went wrong.", 422);
    }
  }

  public function getUsers()
  {
    if (!preg_match('/\b(government|offtakers|village-agents|input-suppliers)\b/', $this->request->user)) {
      return Helpers::returnError("Invalid parameters supplied.", 400);
    }

    $model = [
      "offtakers" => "Offtaker",
      "village-agents" => "VillageAgent",
      "input-suppliers" => "InputSupplier",
      "government" => "Government"

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
