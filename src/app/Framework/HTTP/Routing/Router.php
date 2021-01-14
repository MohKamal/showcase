<?php

namespace  Showcase\Framework\HTTP\Routing {

    use \Showcase\Framework\Views\View;
    use \Showcase\Framework\HTTP\Routing\Response;
    use \Showcase\Framework\HTTP\Gards\CSRF;
    use \Showcase\Framework\IO\Debug\Log;

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
            //Check for CSRF
            if (strtoupper($this->request->requestMethod) === "POST") {
                if (!isset($this->request->getBody()['CSRFName']) or !isset($this->request->getBody()['CSRFToken'])) {
                    //trigger_error("No CSRFName found, probable invalid request.", E_USER_ERROR);
                    Log::print("No CSRFName found, probable invalid request.");
                    return $this->response->unauthorized();
                }
                $name = $this->request->getBody()['CSRFName'];
                $token= $this->request->getBody()['CSRFToken'];
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
