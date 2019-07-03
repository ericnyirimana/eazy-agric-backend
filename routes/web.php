<?php
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
        $router->post('/confirm-password/verify', 'AuthController@verifyResetPasswordToken');
        $router->post('/resend-password', 'AuthController@forgotPassword');
        $router->put('/confirm-password', 'AuthController@confirmPassword');
    });

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->group(['middleware' => 'admin'], function () use ($router) {
            $router->post('/admin', 'AdminController@createAdmin');

            $router->post('/offtaker', 'OfftakerController@createOfftaker');

            $router->post('/masteragent', 'MasterAgentController@createMasterAgent');
            $router->get('/masteragent', 'MasterAgentController@getMasterAgents');

            $router->post('/devt-partners', 'DevtPartnerController@createDevtPartner');

            $router->get('/village-agents', 'VillageAgentController@getVillageAgents');

            $router->get('/input-suppliers', 'InputSupplierController@getInputSuppliers');

            $router->get('/offtakers', 'OfftakerController@getOfftakers');

            $router->get('/devt-partners', 'DevtPartnerController@getDevtPartners');

            $router->get('/top-districts', 'DistrictController@getTopDistricts');
            $router->get('/activity-summary', 'AdminController@getActivitySummary');

            $router->get('/total-acreage', 'MapCordinatesController@getTotalAcreage');
            $router->get('/total-payment', 'TotalPaymentController@getTotalPayment');

            $router->patch('/{id}/activate', 'AdminController@activateAccount');
            $router->patch('/{id}/suspend', 'AdminController@suspendAccount');
        });
    });
    $router->post('/offtaker-request', 'OfftakerController@AccountRequest');
    $router->post('/masteragent-request', 'MasterAgentController@AccountRequest');

});
