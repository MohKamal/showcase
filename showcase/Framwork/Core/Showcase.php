<?php
namespace Showcase\Framwork\Core{
    require_once dirname(__FILE__) . '\..\..\autoload.php';
    require_once dirname(__FILE__) . '\..\Initializer\AppSetting.php';

    use \Showcase\Framwork\Initializer\AppSetting;
    use \Showcase\AutoLoad;
    use \Showcase\Web;

    class Showcase{
        public static function HakunaMatata(){
            AppSetting::Init();
            AutoLoad::register();
            include_once dirname(__FILE__) .'\..\..\route\Web.php';
        }

    }
}