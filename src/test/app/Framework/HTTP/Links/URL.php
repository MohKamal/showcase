<?php
/**
 * 
 * This class regroup all most every link in the showcase
 * 
 * Link to Resources, Base Url, & Boostrap
 * 
 */
namespace  Showcase\Framework\HTTP\Links{

    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\Session\SessionAlert;
    use \Showcase\Framework\IO\Debug\Log;

    class URL
    {
        /**
         * Make a redirection with a message
         */
        static function redirectWithMessage($url, $message, $message_type='info'){
            $_SESSION['sess_flash_message']= array();
            if($message){
                SessionAlert::create($message, $message_type);
            }
            if(!empty($url)) {
                header("Location: " . URL::base() . $url);
            } else {
                header("Location: ".$_SERVER['HTTP_REFERER']);
            }
            exit();
            ob_flush();
        }

        /**
         * Redirection to an url
         * 
         * @param string url to be redirected to
         */
        static function redirect($url, $permanent = false)
        {
            if (headers_sent() === false)
                header('Location: ' . URL::base() . $url, true, ($permanent === true) ? 301 : 302);

            exit();
        }

        /**
         * Generate url from page name
         * @param $page Page name as index.php
         */
        static function view($page){
            return VarLoader::env('VIEW') . $page;
        }

        /**
         * Get base Url
         */
        static function base(){
            return rtrim(VarLoader::env('APP_URL'), '/');
        }

        /**
         * Url to get css files
         */
        static function styles(){
            return '/css?file=';
        }

        /**
         * Url to get script files
         */
        static function scripts(){
            return '/js?file=';
        }

        /**
         * Url to get any file from resources
         */
        static function assets(){
            return '/resources?file=';
        }

        /**
         * Url to get any file from resources
         */
        static function images(){
            return '/images?file=';
        }

        /**
         * Url to the bootstrap.min.css
         */
        static function bootstrapStyle(){
            return self::assets() . 'css/bootstrap/bootstrap-4.3.1-dist/css/bootstrap.min.css';
        }

        /**
         * Url to the bootstrap.min.js
         */
        static function bootstrapScript(){
            return self::assets() . 'css/bootstrap/bootstrap-4.3.1-dist/js/bootstrap.min.js';
        }

        /**
         * Url to the jquery-3.3.1.min.js
         */
        static function jquery(){
            return self::assets() . 'js/jquery-3.3.1.min.js';
        }

        /**
         * Include the routes
         */
        public static function routes($router){
            include dirname(__FILE__) . '/../Controllers/Config/Route/Web.php';
        }

    }
}