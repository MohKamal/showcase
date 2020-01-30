<?php
/**
 * 
 * To create controllers/Models and other files
 * This Cmd class regroup all those functions
 * 
 * Creator file use this file to execute the command line commands
 * 
 */
namespace Showcase\Framework\Command{

    use \Showcase\Framework\Database\Wrapper;

    class Cmd{
        
        /**
         * Create new controller
         * @param string  New controller name
         */
        public function createController($name){
            if(!empty($name)){
                $file = file_get_contents(dirname(__FILE__) . '\..\Resources\Controllers\Controller.php');
                $content = str_replace('NameController', $name, $file);
                file_put_contents(dirname(__FILE__) . '\..\..\Controllers\\' . $name . '.php', $content);
            }
        }
        
        /**
         * Create new Model file
         * @param string new model name
         */
        public function createModel($name){
            if(!empty($name)){
                $file = file_get_contents(dirname(__FILE__) . '\..\Resources\Models\Model.php');
                $content = str_replace('NameModel', $name, $file);
                file_put_contents(dirname(__FILE__) . '\..\..\Models\\' . $name . '.php', $content);
            }
        }

        /**
         * Merge tables to the databse
         */
        public function merge(){
            $db = new Wrapper();
            $db->createTable();
        }

    }
}