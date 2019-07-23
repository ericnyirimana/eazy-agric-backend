<?php

namespace App\Utils;

use App\Models\MasterAgent;
use App\Utils\Email;
use Crisu83\ShortId\ShortId;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;
use Dotenv\Regex\Success;
use Symfony\Component\Mime\Message;

class Helpers extends BaseController
{

  private static $password_string, $url, $mail, $password, $db, $masterAgent;
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

    $deleteAccount = DB::statement('delete from ' . self::$db . ' where _id = ?', [$id]);
    if ($deleteAccount) {

      return $deleteAccount;
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

  public static function returnSuccess($successMessage=null, $data = [], $statusCode)
  {
    $result = array_merge(array_filter(["success" => true, "message" => $successMessage]), $data);
    return response()->json($result, $statusCode);
  }
}
