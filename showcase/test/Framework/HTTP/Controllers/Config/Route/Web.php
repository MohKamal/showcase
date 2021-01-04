<?php
    $router->get('/resources', function ($request) {
        return \Showcase\Framework\HTTP\Controllers\ResourceController::ressource($request);
    });

    $router->get('/css', function ($request) {
        return \Showcase\Framework\HTTP\Controllers\ResourceController::css($request);
    });

    $router->get('/js', function ($request) {
        return \Showcase\Framework\HTTP\Controllers\ResourceController::js($request);
    });

    $router->get('/images', function ($request) {
        return \Showcase\Framework\HTTP\Controllers\ResourceController::images($request);
    });