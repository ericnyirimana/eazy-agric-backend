<?php

namespace App\Http\Controllers;

use App\Models\OffTaker;
use App\Utils\Email;
use App\Utils\Helpers;
use App\Utils\Validation;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Carbon\Carbon;
use App\Utils\DateRequestFilter;

class UserController extends BaseController
{
  private $request, $userData, $email, $url, $requestPassword, $password, $mail, $message, $model;
  public function __construct(Request $request)
  {
    $this->request = $request;
    $this->validate = new Validation();
    $this->helpers = new Helpers();
    $this->model = 'App\Models\\' . $this->request->user;
  }

  public function requestAccount()
  {
    try {
      $this->validate->validateAccountRequest($this->request);
      $password = Helpers::generateId();
      $user = $this->model::create($this->request->all()
        + Helpers::requestInfo($password));

      if (!$user) return Helpers::returnError("Could not create user.", 408);
      $this->helpers->sendPassword($password, $this->request->email);

      return Helpers::returnSuccess("", [$this->request->user => $user], 200);

    } catch (Exception $e) {
      return Helpers::returnError("Something went wrong.", 408);
    }
  }
  public function createUser()
  {
    try {
      $this->validate->validateNewAccount($this->request);
      $user = $this->model::create($this->request->all() + ['_id' => Helpers::generateId()]);

      if (!$user) {
        return Helpers::sendError("Could not create user.", 503);
      }

      $this->helpers->sendPassword($this->requestPassword, $this->email);

      return Helpers::returnSuccess("Please check your mail for your login password.", ['offtaker' => $user], 200);
    } catch (Exception $e) {
      return Helpers::sendError("Something went wrong", 503);
    }
  }
}
