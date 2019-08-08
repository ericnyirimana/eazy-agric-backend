<?php

namespace App\Http\Controllers;

use App\Models\OurCrop;
use Exception;
use App\Utils\Helpers;

class OurCropController extends Controller
{

  /**
   * Gets all enterprises in the database
   * @return object http response
   */
  public function getEnterprises() {
    try {
      $enterprises = OurCrop::query()->selectRaw('crop AS name')->orderBy('crop', 'asc')->get();
      return Helpers::returnSuccess("Enterprises retrieved successfully", ['data' => $enterprises], 200);
    } catch (Exception $e) {
      return Helpers::returnError("Something went wrong.", 503);
    }
  }
}
