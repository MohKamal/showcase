<?php
/**
 * The Main App Class to Start the Showcase
 */
namespace  Showcase\Framework\Core{

    use \Showcase\Framework\Initializer\AppSetting;
    use \Showcase\Framework\Database\Wrapper;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\Utils\Utilities;

    class Showcase{
        /**
         * Load the Env Variables
         * Include the routes
         * Init the database (if the user want to use it)
         */
        public static function HakunaMatata(){
            //init the global settings
            AppSetting::Init();
            //Database init
            $use_db = VarLoader::env('USE_DB');
            if (filter_var(strtolower($use_db), FILTER_VALIDATE_BOOLEAN)) {
                $db = new Wrapper();
                $db->Initialize();
            }
            //including the routes
            self::getRoutes();
        }

        /**
         * Generate the route file
         */
        private static function getRoutes(){
            $file_base = dirname(__FILE__) . '/../HTTP/Routing/Config/web.php';
            $route_base = file_get_contents($file_base);
            
            $file_user = dirname(__FILE__) . '/../../../route/web.php';
            $route_user = file_get_contents($file_user);
            $route_user = str_replace("<?php", '', $route_user);
            $route_user = str_replace("?>", '', $route_user);

            $route_base = str_replace("//URLUSER", $route_user, $route_base);

            $includes = self::includes(dirname(__FILE__) . '/../../Controllers', "Showcase\Controllers");
            $includes .= self::includes(dirname(__FILE__) . '/../../Models', "Showcase\Models");
            $route_base = str_replace("//Includes", $includes, $route_base);

            $temp_file = dirname(__FILE__) . '/../HTTP/Routing/Config/temp_web.php';
            file_put_contents($temp_file, $route_base);
            include_once $temp_file;
            unlink($temp_file);
        }

        private static function includes($dir, $namespace){
            if(!file_exists($dir))
                return "";

            $includes = "";
            $files = scandir($dir);

            //Add use
            if (!Utilities::startsWith($namespace, "user")) {
                if (!Utilities::startsWith($namespace, "\\"))
                    $namespace = "\\$namespace";

                $namespace = "use $namespace";
            }

            if(!Utilities::endsWith($namespace, "\\"))
                $namespace = "$namespace\\";

            foreach ($files as $file) {
                $file_parts = pathinfo($file);
                if($file_parts['extension'] == "php"){
                    $name = basename($file, ".". $file_parts['extension']);
                    $includes .= "$namespace$name;\n";
                }
            }

            return $includes;
        }

    }
}