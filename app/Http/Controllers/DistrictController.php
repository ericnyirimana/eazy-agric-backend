<?php

namespace App\Http\Controllers;

use App\Models\Farmer;

class DistrictController extends Controller
{
    /**
     * Get top performing districts
     *
     * @return http response object
     */
    public function getTopDistricts()
    {
        $districts = Farmer::pluck('farmer_district')->take(4);
        $districtsFarmerCount = [];
        foreach ($districts as $district) {
            if (array_key_exists($district, $districtsFarmerCount)) {
                $districtsFarmerCount[$district] = $districtsFarmerCount[$district] += 1;
            } else {
                $districtsFarmerCount[$district] = 1;
            }
        }
        arsort($districtsFarmerCount);
        return response()->json([
            'success' => true,
            'count' => count($districtsFarmerCount),
            'topDistricts' => $districtsFarmerCount,
        ], 200);
    }
}
