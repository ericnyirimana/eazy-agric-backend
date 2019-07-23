<?php

namespace App\Http\Controllers;

use App\Models\Farmer;

use Illuminate\Http\Request;

use App\Utils\DateRequestFilter;
use App\Utils\Helpers;

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

    $startDateCount = Farmer::where('created_at', '<=', $start_date)->get()->count();
    $endDateCount = Farmer::where('created_at', '<=', $end_date)->get()->count();
    $percentage = DateRequestFilter::getPercentage($startDateCount, $endDateCount);

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
    return Helpers::returnSuccess("", [
      'districtCount' => count($allDistricts),
      'farmerCount' => count($districts),
      'topDistricts' => $topDistricts,
      'allDistricts' => $allDistricts,
      'percentage' => $percentage
    ], 200);
  }
}
