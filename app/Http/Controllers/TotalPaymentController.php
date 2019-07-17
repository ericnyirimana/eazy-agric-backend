<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Order;
use App\Models\MapCoordinate;
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

        $startDateCountMapCordinate = MapCoordinate::where('created_at', '<=', $start_date)->sum('acreage');
        $startDateCountOrder = Order::where('created_at', '<=', $start_date)->sum('details.totalCost');
        $startDateCountSoilTest = SoilTest::where('created_at', '<=', $start_date)->sum('total');
        $startDateCountPlanting = Planting::where('created_at', '<=', $start_date)->sum('total');
        $startDateCountSpraying = Spraying::where('created_at', '<=', $start_date)->sum('total');
        
        $startDateTotal  = ($startDateCountMapCordinate + $startDateCountOrder + $startDateCountSoilTest + $startDateCountPlanting + $startDateCountSpraying);
        
        $endDateCountMapCordinate = MapCoordinate::where('created_at', '<=', $end_date)->sum('acreage');
        $endDateCountOrder = Order::where('created_at', '<=', $end_date)->sum('details.totalCost');
        $endDateCountSoilTest = SoilTest::where('created_at', '<=', $end_date)->sum('total');
        $endDateCountPlanting = Planting::where('created_at', '<=', $end_date)->sum('total');
        $endDateCountSpraying = Spraying::where('created_at', '<=', $end_date)->sum('total');

        $endDateTotal  = ($endDateCountMapCordinate + $endDateCountOrder + $endDateCountSoilTest + $endDateCountPlanting + $endDateCountSpraying);
       
       $percentage = DateRequestFilter::getPercentage($startDateTotal, $endDateTotal);

        try{
            $sumMapCordinate = MapCoordinate::whereBetween('created_at',[$start_date, $end_date])->sum('acreage');
            $sumOrder = Order::whereBetween('created_at',[$start_date, $end_date])->sum('details.totalCost');
            $sumSoilTest = SoilTest::whereBetween('created_at',[$start_date, $end_date])->sum('total');
            $sumPlanting = Planting::whereBetween('created_at',[$start_date, $end_date])->sum('total');
            $sumSpraying = Spraying::whereBetween('created_at',[$start_date, $end_date])->sum('total');
            $sumTotalPayment = ($sumMapCordinate + $sumOrder + $sumSoilTest + $sumPlanting + $sumSpraying);
            return response()->json([
                'success' => true,
                'totalPayment' => $sumTotalPayment,
                'percentagePayment' => $percentage
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.'], 503);
        }
       
    }
}
