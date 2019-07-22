<?php

use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$router->get('/', function () use ($router) {
  return $router->app->version();
});
$router->group(['prefix' => 'api/v1'], function () use ($router) {
  $router->post('/contact', 'ContactController@sendContactForm');

  $router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/login', 'AuthController@authenticate');
    $router->post('/forgot-password', 'AuthController@forgotPassword');
    $router->post('/password-verification-token', 'AuthController@verifyResetPasswordToken');
    $router->post('/resend-password', 'AuthController@forgotPassword');
    $router->put('/confirm-password', 'AuthController@confirmPassword');
  });

  $router->group(['middleware' => 'auth'], function () use ($router) {
    $router->group(['middleware' => 'admin'], function () use ($router) {

      $router->group(['middleware' => 'validateParams'], function () use ($router) {
        $router->post('/create/{user}/', 'UserController@createUser');
      });

      $router->post('/change-password', 'AdminController@changePassword');

      $router->post('/admin', 'AdminController@createAdmin');

      $router->get('/masteragents', 'MasterAgentController@getMasterAgents');
      $router->post('/devt-partners', 'DevtPartnerController@createDevtPartner');

      $router->get('/users/{user}', 'AdminController@getUsers');

      $router->get('/devt-partners', 'DevtPartnerController@getDevtPartners');

      $router->get('/top-districts', 'DistrictController@getTopDistricts');
      $router->get('/activity-summary', 'AdminController@getActivitySummary');

      $router->get('/total-acreage', 'MapCordinatesController@getTotalAcreage');
      $router->get('/total-payment', 'TotalPaymentController@getTotalPayment');


      $router->get('/twitter-report', 'AdminController@getTwitterReport');
      $router->get('/youtube-report', 'AdminController@getYoutubeReport');
      $router->get('/facebook-report', 'AdminController@getFacebookReport');
      $router->get('/admins', 'AdminController@getAdmins');
      $router->delete('/account/{id}', 'AdminController@deleteAccount');
      $router->patch('/account/{id}', 'AdminController@editAccount');
      $router->get('/top-produce', 'FarmerProduceController@getTopFarmProduce');
      $router->get('/top-performing/{agent}', 'AdminController@getTopAgents');
      $router->get('/account/{id}', 'AdminController@getUser');
      $router->patch('/{action}/{id}', 'AdminController@accountAction');
    });
  });
  $router->group(['middleware' => 'validateParams'], function () use ($router) {
    $router->post('/request/{user}', 'UserController@requestAccount');
  });
});
