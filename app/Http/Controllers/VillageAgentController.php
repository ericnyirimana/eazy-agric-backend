<?php

namespace App\Http\Controllers;

use App\VillageAgent;

class VillageAgentController extends Controller
{
    /**
     * Get all village agents
     *
     * @return http response object
     */
    public function getVillageAgents()
    {
        $result = VillageAgent::all();
        return response()->json([
            'success' => true,
            'count' => count($result),
            'villageAgents' => $result,
        ], 200);
    }
}
