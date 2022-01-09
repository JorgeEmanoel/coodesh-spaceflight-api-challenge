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

$router->get('/', function () {
    return 'Back-end Challenge 2021 🏅 - Space Flight News';
});

$router->group(['prefix' => 'articles'], function () use ($router) {
    $router->get('/', 'ArticleController@index');
    $router->get('/{id}', 'ArticleController@show');
});
