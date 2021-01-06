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

    $router  = new Router(new Request);
    
    /**
     * resources routes 
     * Don't delete it
     */
    URL::routes($router);

    $router->get('/', function () {
        HomeController::Index();
    });

    $router->get('/documentation', function () {
        return View::show('App/doc');
    });
}

?>