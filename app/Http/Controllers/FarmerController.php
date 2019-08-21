<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Utils\Helpers;

class FarmerController extends BaseController
{

  /**
   * Get all farmers
   *
   * @return http response object
   */
  public function getFarmers()
  {
    $result = Farmer::all();
    return Helpers::returnSuccess("", [
      'count' => count($result),
      'result' => $result
    ], 200);
  }
}
