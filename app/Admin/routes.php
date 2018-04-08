<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->get('account/create', 'AccountController@create');
    $router->post('account/save', 'AccountController@save')->name('account-save');
    $router->get('account/modify', 'AccountController@modify');
    $router->post('account/do_modify', 'AccountController@do_modify')->name('account-modify');
    $router->get('account/query', 'AccountController@query');
    $router->post('account/do_query', 'AccountController@do_query')->name('account-query');

    $router->get('deal/balance', 'DealController@balance');
    $router->post('deal/show_balance', 'DealController@show_balance')->name('deal-balance');

});
