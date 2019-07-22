<?php

namespace App\Http\Controllers;

use App\Models\MasterAgent;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

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
    return response()->json([
      'success' => true,
      'count' => count($result),
      'result' => $result,
    ], 200);
  }
}
