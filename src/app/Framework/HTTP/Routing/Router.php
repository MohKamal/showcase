<?php

namespace  Showcase\Framework\HTTP\Routing {

    use \Showcase\Framework\Views\View;
    use \Showcase\Framework\HTTP\Routing\Response;
    use \Showcase\Framework\Session\Session;
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
        private $no_auth_url = ['/login', '/reset-password', '/download?file=', '/newregister', '/auth', '/logout', '/register', '/password', '/resources?file=', '/js?file=', '/css?file=', '/images?file='];
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
            if(count($args) < 3) {
                $args[] = false;
            }
            list($route, $method, $public) = $args;
            $route = preg_replace('~/public~', '', $route);
            if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
                $this->invalidMethodHandler();
            }
            if($public) {
                $this->no_auth_url[] = $route;
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
                    $no_auth = true;
                    foreach ($this->no_auth_url as $url) {
                        if($url == '/' && $this->request->requestUri == $url) {
                            $no_auth = false;
                            continue;
                        }

                        if(strpos($this->request->requestUri, '?') !== false || strpos($url, '?') !== false) {
                            if(Utilities::startsWith($this->request->requestUri, $url)) {
                                $no_auth = false;
                                continue;
                            }
                        }

                        if(strpos($url, '{') !== false) {
                            $params = $this->getRouteParam($url);
                            $_url = $url;
                            foreach($params as $param) {
                                $_url = str_replace($param, '', $_url);
                            }

                            if(Utilities::startsWith($this->request->requestUri, $_url)) {
                                $no_auth = false;
                                continue;
                            }
                        }

                        if ($this->request->requestUri === $url) {
                            $no_auth = false;
                        }
                    }

                    if ($no_auth) {
                        if (!Auth::checkRemember()) {
                            Session::store('backBeforeLogin', $this->request->requestUri);
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
            if(is_string($method)) {
                $this->setMethodParametres($method);
                // echo call_user_func_array("\Showcase\\$method", array());
                return;
            }
            echo call_user_func_array($method, array($this->request));
        }
        
        public function __destruct()
        {
            $this->resolve();
        }

        /**
         * Check if the function set to a route has any parametres and set them
         * @param string $method path and name Controllers\HomeController::index
         * @param array $route_with_params the user defined by the user
         * @param array $user_parametres the parametres from the request Uri
         * 
         * @return bool
         */
        private function setMethodParametres($method, $route_with_params=[], $user_parametres=[]){
            $reflection = new \ReflectionMethod("\Showcase\\$method");
            $execution_params = array();
            foreach($reflection->getParameters() AS $arg)
            {
                // If the param is not int or string
                if ((string)$arg->getType() != 'int' && (string)$arg->getType() != 'string' && (string)$arg->getType() != "") {
                    // if the parametre is Request
                    if((string)$arg->getType() == 'Showcase\Framework\HTTP\Routing\Request') {
                        if (count($reflection->getParameters()) == 1) {
                            echo call_user_func_array("\Showcase\\$method", array($this->request));
                            return false;
                        }
                        else{
                            $execution_params[] = $this->request;
                        }
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
                    } else {
                        if(in_array($arg_name, $user_parametres)){
                            if (is_string($route_with_params[$arg_name])) {
                                $execution_params[] = $route_with_params[$arg_name];
                            } else if(is_numeric($route_with_params[$arg_name])){
                                $execution_params[] = $route_with_params[$arg_name];
                            } else {
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

        /**
         * Check if the route has any parametres
         * @param string $route from the request
         * @param array $dictionary of the user routes
         * 
         * @return bool
         */
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
                    $route_with_params[] = $final_route;
            }

            // check again if the route is not empty
            if (count($route_with_params) > 0 && !empty($route_with_params)) {
                // formate the route to its original form
                foreach ($route_with_params as $_route) {
                    $formatRoute = '';
                    foreach ($_route as $key => $value) {
                        $formatRoute .= "/$key";
                    }
                    $user_parametres = array_keys($route_with_params);
                    // Check if the formated route exist in the user web.php
                    if (array_key_exists($formatRoute, $dictionary)) {
                        // get the method
                        $method = $dictionary[$formatRoute];
                        if(!is_string($method))
                                throw new \Exception("The callback method need to be specifyed by string, example: Controllers/Home::index");
                            
                        return $this->setMethodParametres($method, $_route, $user_parametres);
                    }
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

        private function computeDiff($from, $to)
        {
            $diffValues = array();
            $diffMask = array();

            $dm = array();
            $n1 = count($from);
            $n2 = count($to);

            for ($j = -1; $j < $n2; $j++) $dm[-1][$j] = 0;
            for ($i = -1; $i < $n1; $i++) $dm[$i][-1] = 0;
            for ($i = 0; $i < $n1; $i++)
            {
                for ($j = 0; $j < $n2; $j++)
                {
                    if ($from[$i] == $to[$j])
                    {
                        $ad = $dm[$i - 1][$j - 1];
                        $dm[$i][$j] = $ad + 1;
                    }
                    else
                    {
                        $a1 = $dm[$i - 1][$j];
                        $a2 = $dm[$i][$j - 1];
                        $dm[$i][$j] = max($a1, $a2);
                    }
                }
            }

            $i = $n1 - 1;
            $j = $n2 - 1;
            while (($i > -1) || ($j > -1))
            {
                if ($j > -1)
                {
                    if ($dm[$i][$j - 1] == $dm[$i][$j])
                    {
                        $diffValues[] = $to[$j];
                        $diffMask[] = 1;
                        $j--;  
                        continue;              
                    }
                }
                if ($i > -1)
                {
                    if ($dm[$i - 1][$j] == $dm[$i][$j])
                    {
                        $diffValues[] = $from[$i];
                        $diffMask[] = -1;
                        $i--;
                        continue;              
                    }
                }
                {
                    $diffValues[] = $from[$i];
                    $diffMask[] = 0;
                    $i--;
                    $j--;
                }
            }    

            $diffValues = array_reverse($diffValues);
            $diffMask = array_reverse($diffMask);

            return array('values' => $diffValues, 'mask' => $diffMask);
        }
    }
}
