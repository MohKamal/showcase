<?php
namespace Showcase\Framework\Database {
    use \Showcase\AutoLoad;
    use \Showcase\Framework\Initializer\AppSetting;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\SQLite\SQLiteConnection;
    use \Showcase\Framework\Database\SQLite\SQLiteTable;
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;
    
    class Wrapper{

        function __construct(){
            //init the global settings
            AppSetting::Init();
        }

        /**
         * Database base type : SQLite or MySql
         */
        protected $type;

        /**
         * PDO object
         */
        protected $pdo;
        
        /**
         * Initialize the database and get the PDO Object
         */
        public function Initialize(){
            $this->type =  AutoLoad::env('DB_TYPE');
            switch($this->type){
                case 'SQLite':
                    $this->pdo = (new SQLiteConnection())->connect();
                    if ($this->pdo == null)
                        Log::print("SQLite Error : Wrapper.php 19 line \n Whoops, could not connect to the SQLite database!");
                break;
            }
        }

        /**
         * Migrate the tables to database
         */
        public function createTable(Table $table){
            if($this->pdo == null)
                $this->Initialize();
            switch($this->type){
                case 'SQLite':
                    $table->handle();
                    $create = new SQLiteTable($this->pdo);
                    $create->createTables($table->name, $table->columns);
                break;
            }
        }
    }
} 