<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('/listing-types', ListingTypeController::class);
    $router->resource('/locations', LocationController::class);
    $router->resource('/listings', ListingController::class);
    $router->resource('/features', FeatureController::class);
    $router->resource('/facilities', FacilitiesController::class);

});
