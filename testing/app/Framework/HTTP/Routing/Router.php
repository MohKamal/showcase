<?php

namespace  Showcase\Framework\HTTP\Routing {

    use \Showcase\Framework\Views\View;
    use \Showcase\Framework\HTTP\Routing\Response;
    use \Showcase\Framework\HTTP\Gards\CSRF;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\HTTP\Gards\Auth;
    use \Showcase\Framework\Utils\Utilities;

    /**
     * More at : https://medium.com/the-andela-way/how-to-build-a-basic-server-side-routing-system-in-php-e52e613cf241
     */
    class Router
    {
        private $request;
        private $response;
        private $supportedHttpMethods = array(
            "GET",
            "POST"
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
            if (strtoupper($this->request->requestMethod) === "POST") {
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
    }
}
