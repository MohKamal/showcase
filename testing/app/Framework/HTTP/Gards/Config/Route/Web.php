
<?php
    
    $router->get('/login', function () {
        return \Showcase\Framework\Views\View::show('Auth/login', ['appName' => \Showcase\Framework\Initializer\VarLoader::env('APP_NAME')]);
    });

    $router->get('/register', function () {
        return \Showcase\Framework\Views\View::show('Auth/register', ['errors' => array(), 'hasError' => false, 'appName' => \Showcase\Framework\Initializer\VarLoader::env('APP_NAME')]);
    });

    $router->post('/logout', function ($request) {
        return \Showcase\Controllers\LoginController::logout();
    });

    $router->post('/auth', function ($request) {
        return \Showcase\Controllers\LoginController::login($request);
    });

    $router->post('/newregister', function ($request) {
        return \Showcase\Controllers\RegisterController::store($request);
    });