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

        $startDateCount = VillageAgent::where('created_at', '<=', $start_date)->get()->count();
        $endDateCount = VillageAgent::where('created_at', '<=', $end_date)->get()->count();
        $percentage = DateRequestFilter::getPercentage($startDateCount, $endDateCount);
       
        $result = VillageAgent::whereBetween('created_at',[$start_date, $end_date])->get();
        return response()->json([
            'success' => true,
            'count' => count($result),
            'villageAgents' => $result,
            'percentage' => $percentage
        ], 200);
    }
}
