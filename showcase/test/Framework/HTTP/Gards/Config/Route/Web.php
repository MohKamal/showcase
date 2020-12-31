
<?php
    
    $router->get('/login', function () {
        if(\Showcase\Framework\HTTP\Gards\Auth::check())
            return \Showcase\Framework\HTTP\Links\URL::Redirect('/');

        return \Showcase\Framework\Views\View::show('Auth/login');
    });

    $router->get('/register', function () {
        return \Showcase\Framework\Views\View::show('Auth/register', ['errors' => array(), 'hasError' => false]);
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