<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => [ 'api' ]], function (Router $router) {
    $router->get('/ping', 'AuthController@ping');
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('/recovery-password/request', 'AuthController@sendPasswordReset');
    $router->group(['middleware' => [ 'auth:api' ]], function (Router $router) {
        $router->get('/authenticated', 'AuthController@authenticated');
    });
});
