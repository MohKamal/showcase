<?php
/**
 * More at : https://medium.com/@hfally/how-to-create-an-environment-variable-file-like-laravel-symphonys-env-37c20fc23e72
 */
namespace Showcase\Framwork\Initializer{
  use \Showcase\Framwork\IO\Debug\Log;
  
  class AppSetting{

    public static function Init(){
        $variables = [
        'RES_FOLDER' => dirname(__FILE__) . '\..\..\ressources',
        'LOG_FOLDER' => dirname(__FILE__) . '\..\..\Storage\logs',
        'RESOURCES' => dirname(__FILE__) .  '\..\..\ressources\\',
        'VIEW' => 'views/',
        'ROUTE_FOLDER' => 'route/',
      ];
    
        foreach ($variables as $key => $value) {
            putenv("$key=$value");
        }

        $string = file_get_contents(dirname(__FILE__) . "\..\..\appsettings.json");
        if ($string === false) {
          Log::print("appsetting.json file was not found, create one from the example file.");
        }else{
          $json_a = json_decode($string, true);
          if ($json_a === null) {
            Log::print("appsetting.json file has error(s), please check the file or delete it and create another one from the example file.");
          }else{
              foreach ($json_a as $key => $value) {
                  putenv("$key=$value");
            }
          }
        }
    }
  }
}