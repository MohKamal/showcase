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
            //Get the default routes, the uses and includes
            $file_base = dirname(__FILE__) . '/../HTTP/Routing/Config/web.php';
            $route_base = file_get_contents($file_base);
            //Get the user routes
            $file_user = dirname(__FILE__) . '/../../../route/web.php';
            $route_user = file_get_contents($file_user);
            $route_user = str_replace("<?php", '', $route_user);
            $route_user = str_replace("?>", '', $route_user);
            //Insert the user routes to the default files
            $route_base = str_replace("//URLUSER", $route_user, $route_base);
            //Includes the controlles and models
            $includes = self::includes(dirname(__FILE__) . '/../../Controllers', "Showcase\Controllers");
            $includes .= self::includes(dirname(__FILE__) . '/../../Models', "Showcase\Models");
            $route_base = str_replace("//Includes", $includes, $route_base);
            //Save to temp file, to include it
            $temp_file = dirname(__FILE__) . '/../HTTP/Routing/Config/temp_web.php';
            file_put_contents($temp_file, $route_base);
            include_once $temp_file; //Includes the routes file
            unlink($temp_file); //remove the temp routes file
        }

        /**
         * Get the use of all files in a directory
         * @param string $dir folder
         * @param string $namespace to make easy when composing the use
         * 
         * @return string $includes
         */
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