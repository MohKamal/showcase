<?php

namespace  Showcase\Framework\HTTP\Routing {

    use \Showcase\Framework\HTTP\Routing\IResponse;
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Views\View;
    use \Showcase\Framework\IO\Debug\Log;

    /**
     * Response object
     * To make return response easy
     */
    class Response implements IResponse
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
        function redirect($url, $message='', $type='info'){
            if(empty($message))
                return URL::redirect($url);
            return URL::redirectWithMessage($url, $message, $type);
        }

        /**
         * Redirection to preview url with a message
         * 
         * @param string url to be redirected to
         */
        function back($message='', $type='info'){
            return URL::redirectWithMessage('', $message, $type);
        }

        /**
         * Return a json response
         * 
         * @param object data to return
         */
        function json($data, $status_code=200){
            http_response_code($status_code);
            header('Content-Type: application/json');
            return json_encode($data);
        }

        /**
         * Download a file
         */
        function download($file){
            return URL::download($file);
        }

        /**
         * Return a 404 code
         */
        function notFound(){
            http_response_code(404);
            return View::show("Errors/404", ['appName' => VarLoader::env('APP_NAME')]);
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
            return View::show("Errors/403", ['appName' => VarLoader::env('APP_NAME')]);
        }

        /**
         * Return a 500 code
         */
        function internal(){
            http_response_code(500);
            return View::show("Errors/500", ['appName' => VarLoader::env('APP_NAME')]);
        }

        /**
         * Return a 405 code
         */
        function notAllowed(){
            http_response_code(405);
            return View::show("Errors/405", ['appName' => VarLoader::env('APP_NAME')]);
        }
    }
}
