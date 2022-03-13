<?php
namespace  Showcase\Framework\Database {
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\Initializer\AppSetting;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\SQLite\SQLiteConnection;
    use \Showcase\Framework\Database\SQLite\SQLiteTable;
    use \Showcase\Framework\Database\MySql\MySqlConnection;
    use \Showcase\Framework\Database\MySql\MySqlTable;
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Seeding\Seeder;
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
            $this->type =  VarLoader::env('DB_TYPE');
            switch(strtolower($this->type)){
                case 'sqlite':
                    $this->pdo = (new SQLiteConnection())->connect();
                    if ($this->pdo == null)
                        Log::print("SQLite Error : Wrapper.php 38 line \n Whoops, could not connect to the SQLite database!");
                break;
                case 'mysql':
                    $this->pdo = (new MySqlConnection())->connect();
                    if ($this->pdo == null)
                        Log::print("MySql Error : Wrapper.php 43 line \n Whoops, could not connect to the MySql database!");
                break;
            }
        }

        /**
         * Migrate the tables to database
         */
        public function createTable(Table $table, bool $handle=true, bool $handleForeign = true){
            if($this->pdo == null)
                $this->Initialize();
            if ($handle) {
                $table->handle();
            }
            if ($handleForeign) {
                $table->handleForeign();
            }
            $create = null;
            switch(strtolower($this->type)){
                case 'sqlite':
                    $create = new SQLiteTable($this->pdo);
                break;
                case 'mysql':
                    $create = new MySqlTable($this->pdo);
                break;
            }
            $create->createTables($table->name, $table->columns, $table->foreigns);
        }

        /**
         * Seed the data to database
         */
        public function seedData(Seeder $seeder){
            if($this->pdo == null)
                $this->Initialize();
            if ($seeder) {
                $seeder->execute();
            }
        }
    }
} 