<?php
namespace  Showcase\Framework\Session{
    
    /**
     * Session to save variable in the session
     */
    class Cookie{

        /**
         * Store a variable in session
         * @param string $name as the index
         * @param object $variable value to save
         * 
         * @return boolean status
         */
        public static function store($name, $value, array $options=array()){
            if(empty($name))
                return false;
            if(is_null($value))
                return false;

            if (!isset($_COOKIE[$name])) {
                //default values
                $expires = 0;
                $path = "";
                $domain = "";
                $secure = false;
                $httponly = false;
                //user values
                if(key_exists('expires', $options))
                    $expires = (int)$options['expires'];
                
                if(key_exists('path', $options))
                    $path = $options['path'];
                
                if(key_exists('domain', $options))
                    $domain = $options['domain'];
                
                if(key_exists('secure', $options))
                    $secure = (bool)$options['secure'];
                
                if(key_exists('httponly', $options))
                    $httponly = (bool)$options['httponly'];

                setcookie($name, $value, $expires, $path, $domain, $secure,$httponly);
                return true;
            }

            return false;
        }

        /**
         * Retrieve a variable from cookie
         * @param string $name index of the variable
         * 
         * @return object value of the variable
         */
        public static function retrieve($name){
            if(empty($name))
                return false;
                
            if(isset($_COOKIE[$name]))
                return $_COOKIE[$name];
            return null;
        }

        /**
         * Clear cookie
         */
        public static function clear($name){
            if(empty($name))
                return false;
                
            if(isset($_COOKIE[$name]))
                setcookie($name, '', 1);

            return true;
        }

    }
}