<?php

namespace  Showcase\Framework\HTTP\Routing {

    use \Showcase\Framework\Views\View;
    use \Showcase\Framework\HTTP\Routing\Response;
    use \Showcase\Framework\HTTP\Gards\CSRF;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\HTTP\Gards\Auth;
    use \Showcase\Framework\Utils\Utilities;
    use \Showcase\Framework\Database\DB;

    /**
     * More at : https://medium.com/the-andela-way/how-to-build-a-basic-server-side-routing-system-in-php-e52e613cf241
     */
    class Router
    {
        private $request;
        private $response;
        private $supportedHttpMethods = array(
            "GET",
            "POST",
            "PUT",
            "DELETE"
        );

        public function __construct(IRequest $request)
        {
            $this->request = $request;
            $this->response = new Response();
        }

        public function __call($name, $args)
        {
            list($route, $method) = $args;
            $route = preg_replace('~/public~', '', $route);
            if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
                $this->invalidMethodHandler();
            }
            $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
        }

        /**
         * Removes trailing forward slashes from the right of the route.
         * @param route (string)
         */
        private function formatRoute($route)
        {
            $result = rtrim($route, '/public');
            $result = preg_replace('~/public~', '', $result);
            if ($result === '') {
                return '/';
            }

            return $result;
        }

        private function invalidMethodHandler()
        {
            header("{$this->request->serverProtocol} 405 Method Not Allowed");
            return $this->response->notAllowed();
        }

        private function defaultRequestHandler()
        {
            header("{$this->request->serverProtocol} 404 Not Found");
            return $this->response->notFound();
        }

        /**
         * Resolves a route
         */
        public function resolve()
        {
            /**
             * If Auth is activated
             * Need to check if the user is logged
             */
            if(Auth::checkAuth()){
                if (Auth::guest()) {
                    $auths = ['/login', '/reset-password', '/download?file=', '/newregister', '/auth', '/logout', '/register', '/password', '/resources?file=', '/js?file=', '/css?file=', '/images?file='];
                    $no_auth = true;
                    foreach ($auths as $url) {
                        if ($this->request->requestUri === $url || Utilities::startsWith($this->request->requestUri, $url)) {
                            $no_auth = false;
                        }
                    }

                    if ($no_auth) {
                        if (!Auth::checkRemember()) {
                            $this->response->redirect("/login");
                        }
                    }
                }
            }

            //Check for CSRF
            if (strtoupper($this->request->requestMethod) === "POST"|| strtoupper($this->request->requestMethod) === "PUT" || strtoupper($this->request->requestMethod) === "DELETE") {
                if (!isset($this->request->get()['CSRFName']) or !isset($this->request->get()['CSRFToken'])) {
                    //trigger_error("No CSRFName found, probable invalid request.", E_USER_ERROR);
                    Log::print("No CSRFName found, probable invalid request.");
                    return $this->response->unauthorized();
                }
                $name = $this->request->get()['CSRFName'];
                $token= $this->request->get()['CSRFToken'];
                $csrf = new CSRF();
                if (!$csrf->csrfguard_validate_token($name, $token)) {
                    //throw new \Exception("Invalid CSRF token.");
                    Log::print("Invalid CSRF token.");
                    $this->response->unauthorized();
                    return;
                }
            }

            $methodDictionary = $this->{strtolower($this->request->requestMethod)};
            $formatedRoute = preg_replace('~/public~', '', $this->formatRoute(strtok($this->request->requestUri,'?')));
            // Check if the request has parametres
            if($this->checkUrlWithParametres($formatedRoute, $methodDictionary))
                return;
            // If not continue
            if (!array_key_exists($formatedRoute, $methodDictionary)) {
                $this->defaultRequestHandler();
                return;
            }

            $method = $methodDictionary[$formatedRoute];
            echo call_user_func_array($method, array($this->request));
        }
        
        public function __destruct()
        {
            $this->resolve();
        }

        private function checkUrlWithParametres($route, $dictionary) {
            // Get the user routes from web.php for the method used (Get, Post...)
            $routes = array_keys($dictionary);
            // Where the route with the parametre will be stored
            $route_with_params = [];
            
            foreach($routes as $rt) {
                $final_route = [];
                // if the user route has a parametre we will get it
                if (strpos($rt, '{') !== false) {
                    // Explode the route into path section, example /exmaple1/example2 => ['example1', 'example2']
                    $user_route = explode('/', ltrim($rt, '/'));
                    // Do the same to the incoming request URI
                    $request_route = explode('/', ltrim($route, '/'));
                    // Check if the route has the same path lenght
                    if(count($user_route) == count($request_route)) {
                        // get the user route paramteres like {id}, {lang}
                        $params = $this->getRouteParam($rt);
                        // Check if the routes are the same and fill the parametres with their values
                        for($i = 0; $i < count($user_route); $i++) {
                            if ($user_route[$i] == $request_route[$i]) {
                                // add static path
                                $final_route[$user_route[$i]] = $user_route[$i];
                            }
                            else{
                                if(in_array($user_route[$i], $params)) {
                                    // add parametre as key and its value
                                    $final_route[$user_route[$i]] =  $request_route[$i];
                                }
                            }
                        }
                    }
                }
                // if the route is not empty we saved
                if(count($final_route) > 0 && !empty($final_route))
                    $route_with_params = $final_route;
            }

            // check again if the route is not empty
            if (count($route_with_params) > 0 && !empty($route_with_params)) {
                // formate the route to its original form
                $formatRoute = '';
                foreach($route_with_params as $key => $value)
                    $formatRoute .= "/$key";
                $user_parametres = array_keys($route_with_params);
                // Check if the formated route exist in the user web.php
                if (array_key_exists($formatRoute, $dictionary)) {
                    // get the method
                    $method = $dictionary[$formatRoute];
                    if(!is_string($method))
                        throw new \Exception("The callback method need to be specifyed by string, example: Controllers/Home::index");
                    $reflection = new \ReflectionMethod("\Showcase\\$method");
                    $execution_params = array();
                    foreach($reflection->getParameters() AS $arg)
                    {
                        // If the param is not int or string
                        if ((string)$arg->getType() != 'int' && (string)$arg->getType() != 'string') {
                            // if the parametre is Request
                            if((string)$arg->getType() == 'Showcase\Framework\HTTP\Routing\Request') {
                                echo call_user_func_array("\Showcase\\$method", array($this->request));
                            } // If not a Request, we gonna see what is it
                            else if(strpos((string)$arg->getType(), 'Showcase\\') === 0) {
                                // if its a model
                                if(strpos((string)$arg->getType(), 'Showcase\Models\\') === 0) {
                                    $model_name = str_replace('Showcase\Models\\', '', (string)$arg->getType()); // get the model name like User
                                    $id = -1;
                                    $arg_name = '{' . $arg->name . '}'; // get the parameter like {id}
                                    if(in_array($arg_name, $user_parametres)){ // check if the parametre is in the route
                                        $id = $route_with_params[$arg_name];
                                    }else if(in_array("{id}", $user_parametres)){ // if not, check if the id exist
                                        $id = $route_with_params["{id}"];
                                    }

                                    if($id != -1) { // if there is an id we use it
                                        $class = (string)$arg->getType();
                                        $obj = new $class;
                                        $execution_params[] = DB::factory()->model($model_name)->select()->where($obj->getIdName(), $id)->first();
                                    } else {
                                        $class = (string)$arg->getType();
                                        $execution_params[] = new $class;
                                    }
                                } else {
                                    $class = (string)$arg->getType();
                                    $execution_params[] = new $class;
                                }
                            }
                        } else{ // if its int or string
                            $arg_name = '{' . $arg->name . '}'; // get the parameter like {id}
                            if((string)$arg->getType() == 'int') {
                                if(in_array($arg_name, $user_parametres)){
                                    if(is_numeric($route_with_params[$arg_name])){
                                        $execution_params[] = $route_with_params[$arg_name];
                                    }else {
                                        $execution_params[] = 0;
                                    }
                                }else {
                                    $execution_params[] = 0;
                                }
                            }else if((string)$arg->getType() == 'string') {
                                if(in_array($arg_name, $user_parametres)){
                                    if(is_string($route_with_params[$arg_name])){
                                        $execution_params[] = $route_with_params[$arg_name];
                                    }else {
                                        $execution_params[] = '';
                                    }
                                }else {
                                    $execution_params[] = '';
                                }
                            }
                        }
                    }
                    // execute with params
                    echo call_user_func_array("\Showcase\\$method", $execution_params);
                    return true;
                }
            }
            return false;
        }

        private function getRouteParam($route) {
            //Checking the view function to replace them with the correct values
            $matches = array();
            preg_match_all('/{(.*)}/', $route, $matches);
            $parametres = [];
            foreach ($matches[0] as $param) {
                if(strpos($route, '/') !== false) {
                    $param_parts = explode('/', ltrim($param, '/'));
                    foreach($param_parts as $part) {
                        if (strpos($part, '{') !== false) {
                            $parametres[] = $part;
                        }
                    }
                }else {
                    $parametres[] = $param;
                }
            }
            return $parametres;
        }
    }
}
