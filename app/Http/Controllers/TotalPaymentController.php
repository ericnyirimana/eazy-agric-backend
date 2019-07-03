<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Order;
use App\Models\MapCordinates;
use App\Models\SoilTest;
use App\Models\Planting;
use App\Models\Spraying;
use App\Utils\DateRequestFilter;


class TotalPaymentController extends Controller
{
    /**
     * Get total payment made by farmers of EzyAgric
     *
     * @return http response object
     */
    public function getTotalPayment(Request $request)
    {
        $requestArray = DateRequestFilter::getRequestParam($request);
        list($start_date, $end_date) = $requestArray;
        try{
            $sumMapCordinate = MapCordinates::whereBetween('created_at',[$start_date, $end_date])->sum('acreage');
            $sumOrder = Order::whereBetween('created_at',[$start_date, $end_date])->sum('details.totalCost');
            $sumSoilTest = SoilTest::whereBetween('created_at',[$start_date, $end_date])->sum('total');
            $sumPlanting = Planting::whereBetween('created_at',[$start_date, $end_date])->sum('total');
            $sumSpraying = Spraying::whereBetween('created_at',[$start_date, $end_date])->sum('total');
            $sumTotalPayment = ($sumMapCordinate + $sumOrder + $sumSoilTest + $sumPlanting + $sumSpraying);
            return response()->json([
                'success' => true,
                'totalPayment' => $sumTotalPayment
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.'], 503);
        }
       
    }
}
