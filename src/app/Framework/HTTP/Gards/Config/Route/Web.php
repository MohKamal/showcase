
<?php
    
    $router->get('/login', function () {
        if(\Showcase\Framework\HTTP\Gards\Auth::check())
            return \Showcase\Framework\HTTP\Links\URL::Redirect('/');

        return \Showcase\Framework\Views\View::show('Auth/login', ['appName' => \Showcase\Framework\Initializer\VarLoader::env('APP_NAME')]);
    });

    $router->get('/register', function () {
        if(\Showcase\Framework\HTTP\Gards\Auth::check())
            return \Showcase\Framework\HTTP\Links\URL::Redirect('/');
            
        return \Showcase\Framework\Views\View::show('Auth/register', ['errors' => array(), 'hasError' => false, 'appName' => \Showcase\Framework\Initializer\VarLoader::env('APP_NAME')]);
    });

    $router->post('/logout', function ($request) {
        return \Showcase\Controllers\LoginController::logout();
    });

    $router->post('/auth', function ($request) {
        if(\Showcase\Framework\HTTP\Gards\Auth::check())
            return \Showcase\Framework\HTTP\Links\URL::Redirect('/');
            
        return \Showcase\Controllers\LoginController::login($request);
    });

    $router->post('/newregister', function ($request) {
        if(\Showcase\Framework\HTTP\Gards\Auth::check())
            return \Showcase\Framework\HTTP\Links\URL::Redirect('/');
            
        return \Showcase\Controllers\RegisterController::store($request);
    });