<?php

namespace App\Http\Controllers;

use App\Models\InputSupplier;
use App\Utils\Helpers;
use Illuminate\Http\Request;
use App\Models\Order;
use stdClass;


class FarmersOrderController extends Controller
{

  /**
   * Returns transformed order data with category of input and name of farmer
   */
  private static function getTransformedOrders(){
    $transformedOrders = Order::all()->transform(function($item){
      $orders = collect([]);
      foreach($item->orders as $itemOrder){
        // extract order details
        $order = new stdClass();
        $order->category = $itemOrder['category'];
        $order->farmer = $item->details['name'];
        $orders->push($order);
      }
      return $orders;
    });
    return $transformedOrders;
  }

  /**
   * Returns number of Farmers who ordered inputs of different categories.
   * 
   *@return $response object HttpResponse
   */
  public static function getNumberOfFarmersWhoOrderedDifferentInputCategories() {

    $orders = self::getTransformedOrders()->flatten()
    ->groupBy('category')
    ->map(function($collection){
      // count unique farmers
      return $collection->unique('farmer')->count();
    });
    return Helpers::returnSuccess("", ['farmers_orders' => $orders], 200);
  }


}
