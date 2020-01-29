<?php
namespace Showcase\Models{
    use \Exception;
    
    class NameModel
    {

        /**
         * Getter
         * @return Exception
         */
        public function __get($var) {
            throw new Exception("Invalid property $var");
        }

        /**
         * Setter
         * @param string var/value
         */
        public function __set($var, $value) {
            $this->__get($var);
        }

        public function __construct(){
            //Code goes here
        }

    }

}