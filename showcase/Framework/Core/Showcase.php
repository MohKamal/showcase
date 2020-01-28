<?php
namespace Showcase\Framework\Core{
    require_once '\..\..\autoload.php';
    require_once '\..\Initializer\AppSetting.php';
    
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