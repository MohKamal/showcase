<?php
namespace Showcase\Framwork\Core{
    require_once dirname(__FILE__) . '\..\..\autoload.php';
    require_once dirname(__FILE__) . '\..\Initializer\AppSetting.php';
    require_once dirname(__FILE__) .'\..\HTTP\Routing\Route.php';
    require_once dirname(__FILE__) .'\..\..\route\Web.php';

    use \Showcase\Framwork\Initializer\AppSetting;
    use \Showcase\AutoLoad;
    use \Showcase\Framwork\HTTP\Routing\Route;
    use \Showcase\route\Web;

    class Showcase{
        private $route_web;
        public static function HakunaMatata(){
            AppSetting::Init();
            AutoLoad::register();
            Route::Run();

            $route_web = new Web();
            $route_web->run();
        }

    }
}