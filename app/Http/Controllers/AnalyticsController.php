<?php

namespace App\Http\Controllers;

use App\Utils\Helpers;
use App\Services\GoogleClient;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AnalyticsController extends BaseController
{

    private $profileId;
    protected $client;
  
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
      $this->profileId = getenv('GOOGLE_ANALYTICS_PROFILE_ID');
      $this->client= GoogleClient::initializeAnalytics();
    }

      /**
   * get the number of visitors 
   *
   */
  public function getNumberOfVistors()
  {
      $resultObject = $this->client->data_ga->get(
          'ga:' . $this->profileId,
          '7daysAgo',
          'today',
          'ga:users');
      $visitors_array = $resultObject->getRows();
      $visitors = $visitors_array[0][0];
      return Helpers::returnSuccess("", [
        'visitorsCount' => $visitors,
      ], 200);
  }
}
