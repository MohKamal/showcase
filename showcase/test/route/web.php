<?php
/**
 * Routes for routing between requests
 * use $router object to define the routes
 * get and post
 */

$router->get('/', function () {
    return HomeController::Index();
});

$router->get('/documentation', function () {
    return View::show('App/doc', ['doc' => 'You fucker']);
});

$router->post('/user/store', function () {
    return URL::redirect('/');
});

Auth::routes($router);