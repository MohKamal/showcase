<?php
/**
 * More at : https://medium.com/@hfally/how-to-create-an-environment-variable-file-like-laravel-symphonys-env-37c20fc23e72
 */
namespace Facade{
    include_once 'env.php';
    class AutoLoad {

        static function env($key, $default = null){
            $value = getenv($key);
            if ($value === false) {
                return $default;
            }
            return $value;
        }

        static function register(){
            spl_autoload_register(array(__CLASS__, 'autoload'));
        }

        static function autoload($class) {
            if(strpos($class, __NAMESPACE__ . '\\') === 0){
                $class = str_replace(__NAMESPACE__ . '\\', '', $class);
                $class = str_replace('\\', '/', $class);
                require $class . '.php';
            }
        }
    }

}
?>