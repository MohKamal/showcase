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

    /**
     * resources routes 
     * Don't delete it
     */
    URL::routes($router);

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
}

?>