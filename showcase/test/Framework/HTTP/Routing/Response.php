<?php

namespace Showcase\Framework\HTTP\Routing {

    use \Showcase\AutoLoad;
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Views\View;

    /**
     * Response object
     * To make return response easy
     */
    class Response
    {
        public function __construct()
        {
            //Todo
        }

        /**
         * 
         * return a view by name
         * 
         * @param string view name
         */
        function view($view, array $vars=array()){
            return View::show($view, $vars);
        }

        /**
         * Redirection to an url
         * 
         * @param string url to be redirected to
         */
        function redirect($url){
            return URL::Redirect($url);
        }

        /**
         * Return a json response
         * 
         * @param object data to return
         */
        function json($data){
            header('Content-Type: application/json');
            return json_encode($data);
        }

        /**
         * Return a 404 code
         */
        function notFound(){
            http_response_code(404);
            return View::show("Errors/404");
        }

        /**
         * Return a 200 code
         */
        function OK(){
            http_response_code(200);
            return $this->json("ok");
        }

        /**
         * Return a 200 code
         */
        function unauthorized(){
            http_response_code(403);
            return View::show("Errors/403");
        }

        /**
         * Return a 500 code
         */
        function internal(){
            http_response_code(500);
            return View::show("Errors/500");
        }
    }
}
