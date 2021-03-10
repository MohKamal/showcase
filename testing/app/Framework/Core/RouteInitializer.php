<?php
/**
 * The Main App Class to Start the Showcase
 */
namespace  Showcase\Framework\Core{
    use \Showcase\Framework\Utils\Utilities;
    use \Showcase\Framework\IO\Storage\Storage;

    class RouteInitializer {

        /**
         * Generate the route file
         */
        public static function getRoutes(){
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
            $temp_file = Storage::folder('temp')->put('_temp_web.php', $route_base);
            include_once Storage::folder('temp')->path('_temp_web.php'); //Includes the routes file
            Storage::folder('temp')->remove('_temp_web.php'); //remove the temp routes file
        }

        /**
         * Get the use of all files in a directory
         * @param string $dir folder
         * @param string $namespace to make easy when composing the use
         * 
         * @return string $includes
         */
        private static function includes($dir, $namespace) {
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