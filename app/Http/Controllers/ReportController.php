<?php

namespace App\Http\Controllers;


use App\Models\Insurance;
use App\Models\MapCoordinate;
use App\Models\Planting;
use App\Models\SoilTest;
use App\Models\Spraying;
use App\Utils\DateRequestFilter;
use App\Utils\Helpers;
use Exception;
use Illuminate\Http\Request;

class ReportController extends Controller
{
  /**
   * Gets the most ordered products and services,
   * filtered by district or an enterprise
   *
   * @param Request $request
   * @return object http response
   */
  public function getMostOrdered(Request $request) {
    try {
      [ 'type' => $type, 'filter' => $filter ] = $request->all();
      if (!$type || !$filter) return Helpers::returnError('Please supply both the filter and type parameters.', 422);

      $data = [];
      $products = Helpers::getMostOrderedProducts($type, $filter);
      $services = Helpers::getMostOrderedServices($type, $filter);
      $data['products'] = $products;
      $data['services'] = $services;
      return Helpers::returnSuccess(200, ['data' => $data], "");
    } catch (Exception $e) {
      return Helpers::returnError('Something went wrong.', 503);
    }
  }

  /**
   * Gets the farmers and agents-farmer order breakdown,
   *
   * @param Request $request
   * @return object http response
   */
  public function getFarmerAgentsOrderStatistics(Request $request) {
    try {
      $requestArray = DateRequestFilter::getRequestParam($request);
      list($start_date, $end_date) = $requestArray;
      $soilTestOrders = SoilTest::query()->selectRaw('COUNT(*) AS soil_test_farmer, COUNT(vaId) AS soil_test_agent')->whereBetween('created_at', [$start_date, $end_date])->get()->toArray();
      $gardenMappingOrders = MapCoordinate::query()->selectRaw('COUNT(*) AS garden_mapping_farmer, COUNT(vaId) AS garden_mapping_agent')->whereBetween('created_at', [$start_date, $end_date])->get()->toArray();
      $plantingOrders = Planting::query()->selectRaw('COUNT(*) AS planting_farmer, COUNT(vaId) AS planting_agent')->whereBetween('created_at', [$start_date, $end_date])->get()->toArray();
      $insuranceOrders = Insurance::query()->selectRaw('COUNT(*) AS insurance_farmer, COUNT(vaId) AS insurance_agent')->whereBetween('created_at', [$start_date, $end_date])->get()->toArray();
      $sprayingOrders = Spraying::query()->selectRaw('COUNT(*) AS spraying_farmer, COUNT(vaId) AS spraying_agent')->whereBetween('created_at', [$start_date, $end_date])->get()->toArray();
      $farmerOrders = array_merge($soilTestOrders, $gardenMappingOrders, $plantingOrders, $insuranceOrders, $sprayingOrders);
      return Helpers::returnSuccess(200, ['data' => $farmerOrders], "");
    } catch (Exception $e) {
      return Helpers::returnError('Something went wrong.', 503);
    }
  }
}
