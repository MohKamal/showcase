<?php

namespace Showcase\Framework\Initializer{
    
    class VarLoader {

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