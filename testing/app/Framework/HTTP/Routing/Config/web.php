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
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\HTTP\Gards\Auth;
    use \Showcase\Framework\HTTP\Controllers\ResourceController;
    //Includes
    
    $router  = new Router(new Request);

    /**
     * resources routes 
     * Don't delete it
     */
    $router->get('/resources', function ($request) {
        return ResourceController::ressource($request);
    });

    $router->get('/css', function ($request) {
        return ResourceController::css($request);
    });

    $router->get('/js', function ($request) {
        return ResourceController::js($request);
    });

    $router->get('/images', function ($request) {
        return ResourceController::images($request);
    });

    $router->get('/download', function ($request) {
        return ResourceController::download($request);
    });

    //URLUSER
}

?>