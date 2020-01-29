<?php
namespace Showcase\Models{
    use \Exception;
    
    class NameModel
    {

        public function __get($var) {
            throw new Exception("Invalid property $var");
        }

        public function __set($var, $value) {
            $this->__get($var);
        }

        public function __construct(){
        }

    }

}