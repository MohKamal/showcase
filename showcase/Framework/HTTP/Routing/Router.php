<?php

namespace Showcase\Framework\HTTP\Routing {

    use \Showcase\AutoLoad;
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Views\View;

    /**
     * More at : https://medium.com/the-andela-way/how-to-build-a-basic-server-side-routing-system-in-php-e52e613cf241
     */
    class Router
    {
        private $request;
        private $supportedHttpMethods = array(
            "GET",
            "POST"
        );

        public function __construct(IRequest $request)
        {
            $this->request = $request;
        }

        public function __call($name, $args)
        {
            list($route, $method) = $args;
            $route = preg_replace('~' . AutoLoad::env('APP_SUBFOLDER') . '/public~', '', $route);
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
            $result = rtrim($route, AutoLoad::env('APP_SUBFOLDER') . '/public');
            $result = preg_replace('~' . AutoLoad::env('APP_SUBFOLDER') . '/public~', '', $result);
            if ($result === '') {
                return '/';
            }
            return $result;
        }

        private function invalidMethodHandler()
        {
            header("{$this->request->serverProtocol} 405 Method Not Allowed");
            View::show("Errors/405");
        }

        private function defaultRequestHandler()
        {
            header("{$this->request->serverProtocol} 404 Not Found");
            View::show("Errors/404");
        }

        /**
         * Resolves a route
         */
        public function resolve()
        {
            $methodDictionary = $this->{strtolower($this->request->requestMethod)};
            $formatedRoute = preg_replace('~' . AutoLoad::env('APP_SUBFOLDER') . '/public~', '', $this->formatRoute(strtok($this->request->requestUri,'?')));
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
