<?php
/**
 * Require all file
 * Routes for routing between requests
 */

namespace Showcase {

    use \Showcase\Framwork\HTTP\Routing\Router;
    use \Showcase\Framwork\HTTP\Routing\Request;
    use \Showcase\Framwork\Validation\Validator;
    use \Showcase\Framwork\HTTP\Links\URL;
    use \Showcase\Controllers\DegreeController;
    use \Showcase\Controllers\UserController;
    use \Showcase\Controllers\LoginController;
    use \Showcase\Controllers\HomeController;
    use \Showcase\Models\User;

    $router  = new Router(new Request);

    
    $router->get('/', function () {
        return URL::Redirect('login');
    });

    //App Main Page
    $router->get('/user-space', function () {
        HomeController::Dashboard();
    });

    //Authentification and registration
    $router->get('/login', function () {
        if (User::Current() != null) {
            return URL::Redirect('user-space');
        } else {
            return URL::Redirect('views/Auth/login.php');
        }
    });

    $router->post('/auth', function ($request) {
        LoginController::Auth($request);
    });

    $router->get('/register', function () {
        return URL::Redirect('views/Auth/register.php');
    });

    $router->post('/newregister', function ($request) {
        UserController::store($request);
    });

    $router->get('/logout', function ($request) {
        LoginController::logout();
    });

    //Error Pages

    $router->get('/errors/404', function () {
        return URL::Redirect('views/Errors/404.php');
    });

    $router->get('/errors/500', function () {
        return URL::Redirect('views/Errors/500.php');
    });

    //Data Exchange

    //Degree

    $router->post('/degree/create', function ($request) {
        DegreeController::store($request);
    });

    $router->post('/degree/update', function ($request) {
        DegreeController::update($request);
    });
}

?>