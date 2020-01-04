<?php

/**
 * Require all file
 * Routes for routing between requests
 */

namespace Showcase {

    use \Showcase\Framwork\HTTP\Routing\Router;
    use \Showcase\Framwork\HTTP\Routing\Request;
    use \Showcase\Framwork\Validation\Validator;
    use \Showcase\Controllers\DegreeController;
    use \Showcase\Controllers\UserController;
    use \Showcase\Controllers\LoginController;
    use \Showcase\Controllers\HomeController;
    use \Showcase\Framwork\HTTP\Links\URL;
    use \Showcase\Models\User;

    $router = new Router(new Request);
    include_once(dirname(__FILE__) . '\..\..\..\route\web.php');
}
