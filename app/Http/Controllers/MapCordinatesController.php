<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\MapCordinates;

use Carbon\Carbon;

use App\Utils\DateRequestFilter;

class MapCordinatesController extends Controller
{
    /**
     * Get total acreage for farmers using ezyagric
     *
     * @return http response object
     */

    public function getTotalAcreage(Request $request)
    {
        $requestArray = DateRequestFilter::getRequestParam($request);
        list($start_date, $end_date) = $requestArray;
        try{
            $result = ($request->input('start_date') && $request->input('end_date')) ? MapCordinates::whereBetween('created_at', [$start_date, $end_date])
            ->sum('acreage') : MapCordinates::all()->sum('acreage');
            return response()->json([
                'success' => true,
                'totalAcreage' => $result
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.'], 503);
        }
       
    }
}
