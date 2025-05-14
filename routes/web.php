<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
$router->options('{any:.*}', function () {
    return response('', 200);
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('register', 'AuthController@register');
$router->post('/v1/login', 'AuthController@login');

$router->group(['prefix' => 'v1/', 'middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('me', 'AuthController@me');
    // Tambah route lain di sini
    //langganan
    $router->get('paket-pelanggan', 'PaketLanggananController@index');
    $router->post('paket-pelanggan/add', 'PaketLanggananController@create');
    $router->post('paket-pelanggan/{id}/edit', 'PaketLanggananController@update');
    $router->delete('paket-pelanggan/{id}/delete', 'PaketLanggananController@distroy');
    //fitur
    $router->get('fitur', 'FiturController@index');
    $router->post('fitur/add', 'FiturController@create');
    $router->post('fitur/{id}/edit', 'FiturController@update');
    $router->delete('fitur/{id}/delete', 'FiturController@distroy');

    //Paket Fitur
    $router->get('paket-fitur', 'PaketFiturController@index');
    $router->get('paket-fitur/show-select', 'PaketFiturController@showSelect');
    $router->post('paket-fitur/add', 'PaketFiturController@create');
    $router->post('paket-fitur/{id}/edit', 'PaketFiturController@update');
    $router->delete('paket-fitur/{id}/delete', 'PaketFiturController@distroy');
});
