<?php

namespace App\Http\Controllers;

use App\Models\Farmer;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Utils\DateRequestFilter;

class DistrictController extends Controller
{
    /**
     * Get top performing districts
     *
     * @return http response object
     */
    public function getTopDistricts(Request $request)
    {

        $requestArray = DateRequestFilter::getRequestParam($request);
        list($start_date, $end_date) = $requestArray;
        $districts = ($start_date && $end_date) ? Farmer::whereBetween('created_at', [$start_date, $end_date])
        ->pluck('farmer_district')->toArray() : Farmer::pluck('farmer_district')->toArray();
        $allDistricts = [];
        foreach ($districts as $district) {
            if (array_key_exists($district, $allDistricts)) {
                $allDistricts[$district] = $allDistricts[$district] += 1;
            } else {
                $allDistricts[$district] = 1;
            }
        }
        arsort($allDistricts);
        $topDistricts = array_slice($allDistricts, 0, 4, true);
        return response()->json([
            'success' => true,
            'districtCount' => count($allDistricts),
            'farmerCount' => count($districts),
            'topDistricts' => $topDistricts,
            'allDistricts' => $allDistricts
        ], 200);
    }
}
