<?php

namespace App\Http\Controllers;

use App\Models\MasterAgent;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Utils\Helpers;

class MasterAgentController extends BaseController
{

  /**
   * Get all masteragents
   *
   * @return http response object
   */
  public function getMasterAgents()
  {
    $result = MasterAgent::all();
    return Helpers::returnSuccess("", [
      'count' => count($result),
      'result' => $result
    ], 200);
  }
}
