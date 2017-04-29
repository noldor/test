<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/** @var \Illuminate\Routing\Router $router $router */
$router = $this;
$router->auth();
$router->group(['middleware' => 'auth'], function() use ($router) {
    $router->resource('/calculations', 'CalculationController');
    $router->get('/', 'CalculationController@index')->middleware(\App\Http\Middleware\RedirectFromHome::class);
});