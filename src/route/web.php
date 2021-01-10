<?php
/**
 * Routes for routing between requests
 * use $router object to define the routes
 * get and post
 */

$router->get('/', function () {
    HomeController::Index();
});

$router->get('/documentation', function () {
    return View::show('App/doc');
});