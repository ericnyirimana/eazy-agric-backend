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
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('/login', 'AuthController@authenticate');
    });
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('/village-agents', 'VillageAgentController@getVillageAgents');
        $router->get('/input-suppliers', 'InputSupplierController@getInputSuppliers');
        $router->get('/offtakers', 'OfftakerController@getOfftakers');
        $router->get('devt-partners', 'DevtPartnerController@getDevtPartners');

        $router->group(['middleware' => 'admin'], function () use ($router) {
            $router->post('/admin', 'AdminController@createAdmin');
            $router->post('/offtaker', 'OfftakerController@createOfftaker');
            $router->post('/masteragent', 'MasterAgentController@createMasterAgent');
            $router->post('/devt-partners', 'DevtPartnerController@createDevtPartner');
        });

    });
});
