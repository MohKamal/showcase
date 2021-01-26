<?php

namespace Showcase\Framework\Initializer{
    
    class VarLoader {

        /**
         * Get Env variables from appsettings.json files
         * @param string $key of the varaible
         * @param mixed $default value if no value was found
         * 
         * @return mixed
         */
        static function env($key, $default = null){
            $value = getenv($key);
            if ($value === false) {
                return $default;
            }
            return $value;
        }
    }

}
?>