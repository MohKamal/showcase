<?php

namespace  Showcase\Framework\HTTP\Routing {

    /**
     * Response object
     * To make return response easy
     */
    interface IResponse
    {
        /**
         * 
         * return a view by name
         * 
         * @param string view name
         */
        function view($view, array $vars=array());

        /**
         * Redirection to an url
         * 
         * @param string url to be redirected to
         */
        function redirect($url, $message='', $type='info');

        /**
         * Redirection to preview url with a message
         * 
         * @param string url to be redirected to
         */
        function back($message='', $type='info');

        /**
         * Return a json response
         * 
         * @param object data to return
         */
        function json($data, $status_code=200);

        /**
         * Download a file
         */
        function download($file);

        /**
         * Return a 404 code
         */
        function notFound();

        /**
         * Return a 200 code
         */
        function OK();

        /**
         * Return a 200 code
         */
        function unauthorized();

        /**
         * Return a 500 code
         */
        function internal();

        /**
         * Return a 405 code
         */
        function notAllowed();
    }
}
