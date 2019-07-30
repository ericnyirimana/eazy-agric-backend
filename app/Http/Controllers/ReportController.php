<?php

namespace App\Http\Controllers;



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
      return Helpers::returnSuccess('', ['data' => $data], 200);
    } catch (Exception $e) {
      return Helpers::returnError('Something went wrong.', 503);
    }
  }
}
