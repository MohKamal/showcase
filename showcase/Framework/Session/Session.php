<?php
namespace Showcase\Framework\Session{
    
    /**
     * Session to save variable in the session
     */
    class Session{

        /**
         * Store a variable in session
         */
        public static function store($name, $variable){
            if(empty($name))
                return false;
            if(is_null($variable))
                return false;
            session_start();
            $_SESSION[$name] = $variable;
            return true;
        }

        /**
         * Retrieve a variable from
         */
        public static function retrieve($name){
            if(empty($name))
                return false;
                
            session_start();
            if(isset($_SESSION[$name]))
                return $_SESSION[$name];
            return null;
        }
    }
}