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
    use \Showcase\Framework\IO\Debug\Log;

    class Cmd{
        
        /**
         * Create new controller
         * @param string  New controller name
         */
        public function createController($name){
            if(!empty($name)){
                $file = file_get_contents(dirname(__FILE__) . '/../Resources/Controllers/Controller.php');
                $content = str_replace('NameController', $name, $file);
                file_put_contents(dirname(__FILE__) . '/../../Controllers/' . $name . '.php', $content);
                Log::console($name . ' Controller added!');
            }
        }
        
        /**
         * Create new Model file
         * @param string new model name
         */
        public function createModel($name){
            if(!empty($name)){
                $file = file_get_contents(dirname(__FILE__) . '/../Resources/Models/Model.php');
                $content = str_replace('NameModel', $name, $file);
                file_put_contents(dirname(__FILE__) . '/../../Models/' . $name . '.php', $content);
                Log::console($name . ' Model added!');
            }
        }
        
        /**
         * Create new Model file
         * @param string new model name
         */
        public function createMigration($name){
            if(!empty($name)){
                $file = file_get_contents(dirname(__FILE__) . '/../Database/Config/Migration.php');
                $content = str_replace('MigrationName', $name, $file);
                //$file_name = $name . '_table_' . date("Ymdhis") .'.php';
                $file_name = $name . '.php';
                $dir = dirname(__FILE__) . '/../../Database/Migrations/' . $file_name;
                file_put_contents($dir, $content);
                Log::console($name . ' migration file added succefully to ' . $dir);
            }
        }

        /**
         * Create new Model file
         * @param string new model name
         */
        public function test($text){
            if(!empty($text)){
                Log::console($text);
            }
            Log::console("Showcase --version 1.0 working fine for now at " . date("Y-m-d h:i:sa"));
        }

        /**
         * Merge tables to the databse
         */
        public function migrate(){
            $dir = dirname(__FILE__) . '/../../Database/Migrations';
            $db = new Wrapper();
            foreach (glob($dir . '/*.php') as $file)
            {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');

                if (class_exists($class))
                {
                    $obj = new $class;
                    $db->createTable($obj);
                }
            }
            Log::console('Migration ended!');
        }

        /**
         * Create auth tables to the databse
         */
        public function auth(){
            $this->createModel('User');
            $this->createMigration('User');
            Log::console('Migration and Model created! Please run migration command');
        }

    }
}