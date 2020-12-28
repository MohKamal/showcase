<?php
/**
 * More at : https://medium.com/@hfally/how-to-create-an-environment-variable-file-like-laravel-symphonys-env-37c20fc23e72
 * Last version : https://stackoverflow.com/questions/5280347/autoload-classes-from-different-folders
 */
namespace Showcase{
    //require_once dirname(__FILE__) . '\App\Config.php';
    class AutoLoad {

        static function env($key, $default = null){
            $value = getenv($key);
            if ($value === false) {
                return $default;
            }
            return $value;
        }

        static function register(){
            spl_autoload_register(array(__CLASS__, '__autoload'));
        }

        static function __autoload($Class) {
             // Cut Root-Namespace
            $Class = str_replace( __NAMESPACE__.'\\', '', $Class );
            // Correct DIRECTORY_SEPARATOR
            $Class = str_replace( array( '\\', '/' ), DIRECTORY_SEPARATOR, __DIR__.DIRECTORY_SEPARATOR.$Class.'.php' );
            // Get file real path
            if( false === ( $Class = realpath( $Class ) ) ) {
                // File not found
                return false;
            } else {
                require_once( $Class );
                return true;
            }
        }
    }

}
?>