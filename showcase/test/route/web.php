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
    use \Showcase\Controllers\HomeController;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\HTTP\Gards\Auth;

    $router  = new Router(new Request);

    URL::routes($router);

    $router->get('/', function () {
        return HomeController::Index();
    });

    $router->get('/documentation', function () {
        return View::show('App/doc');
    });

    //Error Pages
    $router->get('/errors/404', function () {
        return View::show('Errors/404');
    });

    $router->get('/errors/405', function () {
        return View::show('Errors/405');
    });

    $router->get('/errors/500', function () {
        return View::show('Errors/500');
    });

    Auth::routes($router);
}

?>