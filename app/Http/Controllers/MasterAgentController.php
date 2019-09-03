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
   * @return \Illuminate\Http\JsonResponse
   */
    public function getMasterAgents()
    {
        $result = MasterAgent::all();
        return Helpers::returnSuccess(200, [
      'count' => count($result),
      'result' => $result
    ], "");
    }
}
