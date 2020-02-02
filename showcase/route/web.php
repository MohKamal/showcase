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
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Models\User;

    $router  = new Router(new Request);

    $router->get('/', function () {
        $user = new User();
        $user->name = "Mohamed";
        $user->phone = "67584848";
        $user->save();
        Log::print("user id " . $user->id);
        HomeController::Index();
    });

    $router->get('/documentation', function () {
        return View::show('App/doc');
    });
    

    $router->get('/login', function () {
        return View::show('Auth/login');
    });

    //Error Pages
    $router->get('/errors/404', function () {
        return View::show('Errors/404');
    });

    $router->get('/errors/500', function () {
        return View::show('Errors/500');
    });
}

?>