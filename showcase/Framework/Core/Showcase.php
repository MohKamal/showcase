<?php
namespace Showcase\Framework\Core{
    require_once dirname(__FILE__) . '\..\..\public\autoload.php';
    require_once dirname(__FILE__) . '\..\Initializer\AppSetting.php';
    
    use \Showcase\AutoLoad;

    AutoLoad::register();
    
    use \Showcase\Framework\Initializer\AppSetting;
    use \Showcase\Web;

    class Showcase{
        public static function HakunaMatata(){
            AppSetting::Init();
            AutoLoad::register();
            include_once dirname(__FILE__) .'\..\..\route\Web.php';
        }

    }
}