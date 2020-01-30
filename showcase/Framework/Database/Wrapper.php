<?php
namespace Showcase\Framework\Database {
    use \Showcase\AutoLoad;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\SQLite\SQLiteConnection;
    use \Showcase\Framework\Database\SQLite\SQLiteCreateTable;
    
    class Wrapper{

        /**
         * Database base type : SQLite or MySql
         */
        private $type;

        /**
         * PDO object
         */
        private $pdo;
        
        /**
         * Initialize the database and get the PDO Object
         */
        public function Initialize(){
            $this->type =  AutoLoad::env('DB_TYPE');
            Log::print('Select db type : ' . $this->type);
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
        public function createTable(){
            if($this->pdo == null)
                $this->Initialize();
            switch($this->type){
                case 'SQLite':
                    $create = new SQLiteCreateTable($this->pdo);
                    $create->createTables('User', array('id' => array('int', 'not null'), 'name' => array('varchar(100)', 'not null')));
                break;
            }
        }
    }
} 