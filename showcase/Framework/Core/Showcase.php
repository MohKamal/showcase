<?php
/**
 * 
 * The Main App Class to Start the Showcase
 * 
 */
namespace Showcase\Framework\Core{
    require_once dirname(__FILE__) . '\..\..\autoload.php';
    require_once dirname(__FILE__) . '\..\Initializer\AppSetting.php';
    
    use \Showcase\AutoLoad;

    /**
     * 
     * Register the autoloader
     * 
     */
    AutoLoad::register();
    
    use \Showcase\Framework\Initializer\AppSetting;
    use \Showcase\Web;

    class Showcase{

        /**
         * Load the Env Variables
         * 
         * Include the routes
         */
        public static function HakunaMatata(){
            AppSetting::Init();
            include_once dirname(__FILE__) .'\..\..\route\Web.php';
        }

    }
}