<?php

namespace App\Utils;

use App\Models\Farmer;
use App\Models\InputOrder;
use App\Models\Insurance;
use App\Models\MapCoordinate;
use App\Models\MasterAgent;
use App\Models\ActivityLog;
use App\Models\Planting;
use App\Models\SoilTest;
use App\Models\Spraying;
use App\Utils\Email;
use Crisu83\ShortId\ShortId;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class Helpers extends BaseController
{

  private static $url, $mail, $db, $masterAgent;
  public static $user;
  public function __construct()
  {
    self::$mail = new Email();
    self::$url = getenv('FRONTEND_URL');
    self::$db = getenv('DB_DATABASE');
    self::$masterAgent = new MasterAgent();
  }

  /**
   * Create a new token for user object.
   *
   * @param  \App\User   $user
   * @param $db
   * @return string
   */
  public static function jwt($user, $db = null, $exp = (60 * 60 * 24 * 7))
  {
    $payload = [
      'iss' => "lumen-jwt", // Issuer of the token
      'sub' => $db !== null ? $user[0][$db]['_id'] : $user, // Subject of the token
      'iat' => time(), // Time when JWT was issued.
      'exp' => time() + $exp, // Expiration time
    ];
    return JWT::encode($payload, env('JWT_SECRET'));
  }

  /**
   * Generate Random Numbers
   * @return string
   */

  public static function generateId()
  {
    $shortid = ShortId::create();

    return $shortid->generate();
  }

  public static function requestInfo($password)
  {
    return [
      '_id' => self::generateId(),
      'district' => 'N/A',
      'value_chain' => 'N/A',
      'account_type' => 'Generic',
      'contact_person' => 'N/A',
      'password' => $password,
    ];
  }

  /**
   * Send user password via mail
   * @param string password
   * @param string email
   * @return boolean true or false
   */
  public function sendPassword($password, $email)
  {
    $sendEmail = self::$mail->mailWithTemplate(
      'LOGIN',
      $email,
      self::$url,
      $password
    );

    if ($sendEmail) {
      return true;
    }
  }

  /**
   * Get a user by id
   * @param string id
   * @return object user
   */

  public static function queryUser($id)
  {
    return $query = DB::select('select * from ' . self::$db . ' where _id = ?', [$id]);
  }

  public static function logActivity($info, $activity, $type = 'admin')
  {
    return $activity = ActivityLog::create([
      'email' => $info['email'],
      'target_email' => $info['target_email'],
      'target_account_name' => $info['target_account_name'],
      'activity' => $activity,
      'type' => $type
    ]);
  }

  /**
   * Change user account status
   * @param string user id
   * @param string status
   *@return boolean true or false
   */

  public static function changeStatus($id, $status)
  {
    $user = self::queryUser($id);
    if (count($user) < 1) {
      return false;
    }
    $query = "UPDATE " . self::$db .
      " SET status='" . $status . "'WHERE _id= '" . $id .
      "' Returning * ";

    $status = DB::statement($query);

    if ($status->status === 'success') {
      return true;
    }
  }

  /**
   * delete user
   * @param string id
   * @return object query result
   */
  public static function deleteUser($id)
  {

    $deleteAccount = DB::statement('delete from ' . self::$db . ' where _id = ? returning *', [$id]);
    if ($deleteAccount) {

      return $deleteAccount->rows;
    }
    return false;
  }
  /**
   * Edit account
   * @param string id
   * @param array data
   * @return object query result
   */
  public static function editAccount($id, $data)
  {

    $fields = [];
    $values = [];
    foreach ($data as $key => $value) {
      $fields[] = "${key} = ?";
      $values[] = $value;
    }
    array_push($values, $id);
    $query = 'UPDATE ' . self::$db . ' SET ' . join($fields, ",") . ' WHERE _id=?';
    $queryResult = DB::statement($query, $values);
    if (!$queryResult) {
      return false;
    }
    return $queryResult;
  }

  public static function checkUser($id)
  {
    $user = self::queryUser($id);
    unset($user[0][self::$db]['password']);
    return $user ? $user[0][self::$db] : false;
  }

  public static function returnError($errorMessage, $statusCode)
  {
    return response()->json([
      "success" => false,
      "error" => $errorMessage
    ], $statusCode);
  }

  public static function returnSuccess($successMessage = null, $data = [], $statusCode)
  {
    $result = array_merge(array_filter(["success" => true, "message" => $successMessage]), $data);
    return response()->json($result, $statusCode);
  }

  /**
   * Gets the top districts ranked by the number of app downloads
   */
  public static function getTopDistrictsByAppDownloads()
  {
    $topDistrictsByAppDownloads = DB::select("SELECT farmer.farmer_district AS name, COUNT(farmer.farmer_district) AS appDownloads
      FROM " . self::$db . " farmer 
      INNER JOIN " . self::$db . " account 
      ON KEYS ('account::' || farmer.farmer_id) 
      WHERE account.type == 'account'
        AND farmer.type == 'farmer'
      GROUP BY farmer.farmer_district
      ORDER BY appDownloads DESC LIMIT 5");
    return $topDistrictsByAppDownloads;
  }

  /**
   * Returns the most ordered products,
   * filtered by enterprise(crop) or district
   *
   * @param string type - filter type
   * @param string filter - filter value
   * @return array products
   */
  public static function getMostOrderedProducts($type = 'enterprise', $filter = '') {
    $products = "";
    if ($type == 'enterprises') {
      $enterpriseFarmers = Farmer::query()->select('_id')->where('value_chain', '=', $filter)->get()->toArray();
      $farmerIDs = array_map(function ($enterpriseFarmer) { return $enterpriseFarmer['_id']; }, $enterpriseFarmers );
      $productOrders = InputOrder::query()->select('orders[*].product')->whereIn('user_id', $farmerIDs)->get()->toArray();
      $products = array_map(function ($product) { return $product['product']; }, $productOrders);
    } else if ($type == 'districts') {
      $productOrders = InputOrder::query()->select('orders[*].product')->where('details.district', '=', $filter)->get()->toArray();
      $products = array_map(function ($product) { return $product['product']; }, $productOrders);
    }
    return $products;
  }

  /**
   * Returns the most ordered services,
   * filtered by enterprise(crop) or district
   *
   * @param string type - filter type
   * @param string filter - filter value
   * @return array services
   */
  public static function getMostOrderedServices($type = 'enterprise', $filter = '') {
    $services = "";
    if ($type == 'enterprises') {
      $enterpriseFarmers = Farmer::query()->select('_id')->where('value_chain', '=', $filter)->get()->toArray();
      $farmerIDs = array_map(function ($enterpriseFarmer) { return $enterpriseFarmer['_id']; }, $enterpriseFarmers );
      $mapCoordinates = MapCoordinate::query()->select('COUNT(*) AS garden_mapping')->whereIn('user_id', $farmerIDs)->get()->toArray();
      $soilTest = SoilTest::query()->select('COUNT(*) AS soil_test')->whereIn('user_id', $farmerIDs)->get()->toArray();
      $planting = Planting::query()->select('COUNT(*) AS planting')->whereIn('user_id', $farmerIDs)->get()->toArray();
      $spraying = Spraying::query()->select('COUNT(*) AS spraying')->whereIn('user_id', $farmerIDs)->get()->toArray();
      $insurance = Insurance::query()->select('COUNT(*) AS insurance')->where('request.crop_insured', '=', $filter)->get()->toArray();
      $services = array_merge($mapCoordinates, $soilTest, $planting, $spraying, $insurance);
    } else if ($type == 'districts') {
      $enterpriseFarmers = Farmer::query()->select('_id')->where('farmer_district', '=', $filter)->get()->toArray();
      $farmerIDs = array_map(function ($enterpriseFarmer) { return $enterpriseFarmer['_id']; }, $enterpriseFarmers );
      $mapCoordinates = MapCoordinate::query()->select('COUNT(*) AS garden_mapping')->whereIn('user_id', $farmerIDs)->get()->toArray();
      $soilTest = SoilTest::query()->select('COUNT(*) AS soil_test')->where('district', '=', $filter)->get()->toArray();
      $planting = Planting::query()->select('COUNT(*) AS planting')->where('district', '=', $filter)->get()->toArray();
      $spraying = Spraying::query()->select('COUNT(*) AS spraying')->where('district', '=', $filter)->get()->toArray();
      $insurance = Insurance::query()->select('COUNT(*) AS insurance')->whereIn('user_id', $farmerIDs)->get()->toArray();
      $services = array_merge($mapCoordinates, $soilTest, $planting, $spraying, $insurance);
    }
    return $services;
  }
}
