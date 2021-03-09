<?php
/**
 * 
 * To create controllers/Models and other files
 * This Cmd class regroup all those functions
 * 
 * Creator file use this file to execute the command line commands
 * 
 */
namespace  Showcase\Framework\Command{

    use \Showcase\Framework\Database\Wrapper;
    use \Showcase\Framework\IO\Debug\Log;

    class Cmd{

        /**
         * Parse the command to get best results
         * @param array $command commands from bash
         * 
         * @return boolean
         */
        public function parse($command){
            if(count($command) <= 1)
            {
                Log::console("No command find! please specify your command", 'error');
                return false;
            }
            if (strpos($command[1], ":") !== false) {
                $commands = explode(":", $command[1]);
                if(count($command) <= 2)
                    return $this->errorCommand($commands[0]);
                if(strtolower($commands[0]) === "make"){

                    switch(strtolower($commands[1])){
                        case 'controller':
                            $this->createController($command[2]);
                            break;
                        case 'model':
                            $this->createModel($command[2]);
                            break;
                        case 'jsonresource':
                            $this->createJsonResource($command[2]);
                            break;
                        case 'migration':
                            $this->createMigration($command[2]);
                            break;
                    }
                }
            }

            if(count($command) >= 2){
                switch(strtolower($command[1])){
                    case '-v':
                        $text = '';
                        if(isset($command[2]))
                            $text = $command[2];
                        $this->v($text);
                        break;
                }
            }

            if(count($command) == 2){
                switch(strtolower($command[1])){
                    case 'migrate':
                        $this->migrate();
                        break;
                    case 'auth':
                        $this->auth();
                        break;
                }
            }

            return true;
        }

        /**
         * Error message for each command, to help user executing the commands
         * @param string $command name
         * 
         * @return boolean
         */
        private function errorCommand($command){
            switch(strtolower($command)){
                case 'make':
                    Log::console("make need more option\nmake:controller\nmake:model\nmake:jsonresource\nmake:migration", 'error');
                    break;
            }

            return false;
        }
        
        /**
         * Create new controller
         * @param string  New controller name
         */
        public function createJsonResource($name){
            if(!empty($name)){
                $file = file_get_contents(dirname(__FILE__) . '/../Resources/JsonResources/JsonResrouce.php');
                $content = str_replace('ResourceName', $name, $file);
                $base_dir = dirname(__FILE__) . '/../../JsonResources/';
                if (!file_exists($base_dir)) {
                    mkdir($base_dir, 0777, true);
                }
                file_put_contents($base_dir . $name . '.php', $content);
                Log::console($name . ' Json Resource added!', 'success');
            }
        }

                /**
         * Create new controller
         * @param string  New controller name
         */
        public function createController($name){
            if(!empty($name)){
                $file = file_get_contents(dirname(__FILE__) . '/../Resources/Controllers/Controller.php');
                $content = str_replace('NameController', $name, $file);
                $base_dir = dirname(__FILE__) . '/../../Controllers/';
                if (!file_exists($base_dir)) {
                    mkdir($base_dir, 0777, true);
                }
                file_put_contents($base_dir . $name . '.php', $content);
                Log::console($name . ' Controller added!', 'success');
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
                $base_dir = dirname(__FILE__) . '/../../Models/';
                if (!file_exists($base_dir)) {
                    mkdir($base_dir, 0777, true);
                }
                file_put_contents($base_dir . $name . '.php', $content);
                Log::console($name . ' Model added!', 'success');
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
                $base_dir = dirname(__FILE__) . '/../../Database/Migrations/';
                if (!file_exists($base_dir)) {
                    mkdir($base_dir, 0777, true);
                }
                $dir = $base_dir . $file_name;
                file_put_contents($dir, $content);
                Log::console($name . ' migration file added succefully', 'success');
            }
        }

        /**
         * Create new Model file
         * @param string new model name
         */
        public function v($text=''){
            if(!empty($text)){
                Log::console($text . "\n");
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
                    Log::console("Migration $obj->name created!\n", 'success');
                }
            }
            Log::console('Migration ended!', 'success');
        }

        /**
         * Create auth tables to the databse
         */
        public function auth(){
            $config_folder = dirname(__FILE__) . '/../HTTP/Gards/Config/';

            //Migration
            $migration_user = $config_folder . 'Migration/User.php';
            $migration_remember = $config_folder . 'Migration/rememberMe.php';
            $base_dir = dirname(__FILE__) . '/../../Database/Migrations/';
            $migration_user_newFolder = $base_dir . 'User.php';
            $migration_remember_newFolder = $base_dir . 'rememberMe.php';
            if (!file_exists($base_dir)) {
                mkdir($base_dir, 0777, true);
            }

            if(!copy($migration_user, $migration_user_newFolder)){
                Log::console("Can't create User migration", 'error');
                return false;
            }            
            
            if(!copy($migration_remember, $migration_remember_newFolder)){
                Log::console("Can't create rememberMe migration", 'error');
                return false;
            }

            //Controllers
            $loginController = $config_folder . 'Controller/LoginController.php';
            $userContoller = $config_folder . 'Controller/UserController.php';
            $registerController = $config_folder . 'Controller/RegisterController.php';

            $base_dir = dirname(__FILE__) . '/../../Controllers/';
            if (!file_exists($base_dir)) {
                mkdir($base_dir, 0777, true);
            }
 
            $loginController_newFolder = $base_dir . 'LoginController.php';
            $userContoller_newFolder = $base_dir . 'UserController.php';
            $registerController_newFolder = $base_dir . 'RegisterController.php';

            if(!copy($loginController, $loginController_newFolder)){
                Log::console("Can't create contollers", 'error');
                return false;
            }

            if(!copy($userContoller, $userContoller_newFolder)){
                Log::console("Can't create contollers", 'error');
                return false;
            }    

            if(!copy($registerController, $registerController_newFolder)){
                Log::console("Can't create contollers", 'error');
                return false;
            }

            //Model
            $userModel = $config_folder . 'Model/User.php';

            $base_dir = dirname(__FILE__) . '/../../Models/';
            if (!file_exists($base_dir)) {
                mkdir($base_dir, 0777, true);
            }

            $userModel_newFolder = $base_dir . 'User.php';

            if(!copy($userModel, $userModel_newFolder)){
                Log::console("Can't create User model", 'error');
                return false;
            }

            //Views
            $loginView = $config_folder . 'View/login.view.php';
            $registerView = $config_folder . 'View/register.view.php';
            $mainView = $config_folder . 'View/main.view.php';

            $base_dir = dirname(__FILE__) . '/../../../resources/views/Auth/';
            if (!file_exists($base_dir)) {
                mkdir($base_dir, 0777, true);
            }

            $loginView_newFolder = $base_dir . 'login.view.php';
            $registerView_newFolder = $base_dir . 'register.view.php';
            $mainView_newFolder = dirname(__FILE__) . '/../../../resources/views/App/' . 'main.view.php';

            if(!copy($loginView, $loginView_newFolder)){
                Log::console("Can't create views", 'error');
                return false;
            }

            if(!copy($registerView, $registerView_newFolder)){
                Log::console("Can't create views", 'error');
                return false;
            }

            if(!copy($mainView, $mainView_newFolder)){
                Log::console("Can't create views", 'error');
                return false;
            }

            //ConfigFile
            $config_file = $config_folder . "/config.json";
            $jsonString = file_get_contents($config_file);
            $data = json_decode($jsonString, true);
            $data["auth"] = "true";
            $newJsonString = json_encode($data);
            file_put_contents($config_file, $newJsonString);

            Log::console("Migration, Contollers, Views and Model created! Please run migrate command\n", 'success');
            Log::console('Add Auth::routes($router); to the route web file (route/web.php)', 'success');
        }
    }
}