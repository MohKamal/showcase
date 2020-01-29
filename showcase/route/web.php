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

    $router->get('/documentation', function () {
        return View::show('App/doc');
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