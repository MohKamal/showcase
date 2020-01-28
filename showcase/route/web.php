<?php
/**
 * Require all file
 * Routes for routing between requests
 */

namespace Showcase {

    use \Showcase\Framework\HTTP\Routing\Router;
    use \Showcase\Framework\HTTP\Routing\Request;
    use \Showcase\Framework\Validation\Validator;
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Views\View;
    use \Showcase\Controllers\DegreeController;
    use \Showcase\Controllers\UserController;
    use \Showcase\Controllers\LoginController;
    use \Showcase\Controllers\HomeController;
    use \Showcase\Models\User;

    $router  = new Router(new Request);

    
    $router->get('/', function () {
        HomeController::dashboard();
    });

    //Authentification and registration
    $router->get('/login', function () {
        if (User::Current() != null) {
            return URL::Redirect('user-space');
        } else {
            View::show('Auth/login.view.php');
            //return URL::Redirect('views/Auth/login.php');
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