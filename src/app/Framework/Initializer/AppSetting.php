<?php
/**
 * More at : https://medium.com/@hfally/how-to-create-an-environment-variable-file-like-laravel-symphonys-env-37c20fc23e72
 */
namespace  Showcase\Framework\Initializer{
  use \Showcase\Framework\IO\Debug\Log;
  use \Showcase\Framework\IO\Storage\Storage;
  
  class AppSetting{

    /**
     * Add variables to the global from the appsettings.json
     */
    public static function Init(){
      /**
       * Global variables
       * @var array
       */
        $variables = [];
    
        foreach ($variables as $key => $value) {
            putenv("$key=$value");
        }

        //Check if the files exists or not
        $_variables = Storage::global()->get('appsettings.json');
        if ($_variables === false) {
          Log::print("appsetting.json file was not found, create one from the example file.");
        }else{
          $json_variables = json_decode($_variables, true);
          if ($json_variables === null) {
            Log::print("appsetting.json file has error(s), please check the file or delete it and create another one from the example file.");
          }else{
            //if exist add all to the global variables
              foreach ($json_variables as $key => $value) {
                  putenv("$key=$value");
            }
          }
        }
    }
  }
}