<?php

namespace App\Http\Controllers;

use App\Models\Farmer;

use Illuminate\Http\Request;

use App\Utils\DateRequestFilter;
use App\Utils\Helpers;

class FarmerProduceController extends Controller
{
    /**
     * Get top farm produce
     *
     * @return http response object
     */
    public function getTopFarmProduce(Request $request)
    {
        $requestArray = DateRequestFilter::getRequestParam($request);
        list($start_date, $end_date) = $requestArray;
        
        try {
            $farmProduces = ($start_date && $end_date) ? Farmer::whereBetween('created_at', [$start_date, $end_date])
        ->pluck('value_chain')->toArray() : Farmer::pluck('value_chain')->toArray();
            $allFarmProduce = [];
            foreach ($farmProduces as $farmProduce) {
                if (array_key_exists($farmProduce, $allFarmProduce)) {
                    $allFarmProduce[$farmProduce] = $allFarmProduce[$farmProduce] += 1;
                } else {
                    $allFarmProduce[$farmProduce] = 1;
                }
            }
            arsort($allFarmProduce);
            $topFarmProduce = array_slice($allFarmProduce, 0, 5, true);
        
            return response()->json([
            'success' => true,
            'farmProduceCount' => count($farmProduces),
            'topFarmProduce' => $topFarmProduce,
            'allFarmProduce' => $allFarmProduce
        ], 200);
        } catch (Exception $e) {
            return Helpers::returnError("Something went wrong.", 503);
        }
    }
}
