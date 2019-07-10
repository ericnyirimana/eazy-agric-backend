<?php

namespace App\Http\Controllers;

use App\Models\VillageAgent;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Utils\DateRequestFilter;

class VillageAgentController extends Controller
{
    /**
     * Get all village agents
     *
     * @return http response object
     */
    public function getVillageAgents(Request $request)
    {
        $requestArray = DateRequestFilter::getRequestParam($request);
        list($start_date, $end_date) = $requestArray;
        $result = VillageAgent::whereBetween('created_at',[$start_date, $end_date])->get();
        return response()->json([
            'success' => true,
            'count' => count($result),
            'villageAgents' => $result,
        ], 200);
    }
}
