<?php
namespace Showcase\Framework\Command{

    class Cmd{
        
        public function createController($name){
            if(!empty($name)){
                $file = file_get_contents(dirname(__FILE__) . '\..\Resources\Controllers\Controller.php');
                $content = str_replace('NameController', $name, $file);
                file_put_contents(dirname(__FILE__) . '\..\..\Controllers\\' . $name . '.php', $content);
            }
        }
        
        public function createModel($name){
            if(!empty($name)){
                $file = file_get_contents(dirname(__FILE__) . '\..\Resources\Models\Model.php');
                $content = str_replace('NameModel', $name, $file);
                file_put_contents(dirname(__FILE__) . '\..\..\Models\\' . $name . '.php', $content);
            }
        }

    }
}