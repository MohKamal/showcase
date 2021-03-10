<?php
/**
 * The Main App Class to Start the Showcase
 */
namespace  Showcase\Framework\Core{

    use \Showcase\Framework\Initializer\AppSetting;
    use \Showcase\Framework\Database\Wrapper;
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\Core\RouteInitializer;

    class Showcase {
        /**
         * Load the Env Variables
         * Include the routes
         * Init the database (if the user want to use it)
         */
        public static function start(){
            //init the global settings
            AppSetting::Init();
            //Database init
            if (filter_var(strtolower(VarLoader::env('USE_DB')), FILTER_VALIDATE_BOOLEAN)) {
                $db = new Wrapper();
                $db->Initialize();
            }
            //including the routes
            RouteInitializer::getRoutes();
        }
    }
}