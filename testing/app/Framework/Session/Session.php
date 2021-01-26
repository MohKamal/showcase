<?php
namespace  Showcase\Framework\Session{
    
    /**
     * Session to save variable in the session
     */
    class Session{

        /**
         * Store a variable in session
         * @param string $name as the index
         * @param object $variable value to save
         * 
         * @return boolean status
         */
        public static function store($name, $variable, $lifetime=0){
            if(empty($name))
                return false;
            if(is_null($variable))
                return false;
            if (session_status() == PHP_SESSION_NONE) {
                if($lifetime > 0)
                    session_start([
                        'gc_maxlifetime' => $lifetime,
                    ]);
                else
                    session_start();
            }
            $_SESSION[$name] = $variable;
            return true;
        }

        /**
         * Retrieve a variable from
         * @param string $name index of the variable
         * 
         * @return object value of the variable
         */
        public static function retrieve($name){
            if(empty($name))
                return false;
            if (session_status() == PHP_SESSION_NONE)
                session_start();
            if(isset($_SESSION[$name]))
                return $_SESSION[$name];
            return null;
        }

        /**
         * Clear session
         */
        public static function clear($name){
            $_SESSION[$name] = null;
        }

    }
}