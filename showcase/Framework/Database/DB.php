<?php
namespace Showcase\Framework\Database {
    use \Showcase\Framework\Database\Wrapper;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\SQLite\SQLiteTable;
    use \Showcase\Framework\Database\MySql\MySqlTable;
    use \Showcase\Framework\Database\SQLite\SQLiteConnection;
    use \Showcase\Framework\Database\MySql\MySqlConnection;
    use \Showcase\Framework\Database\Config\Column;
    use \Showcase\Framework\Database\Config\Converter;
    use \Showcase\AutoLoad;

    class DB extends Wrapper{

        private static $_pdo = null;
        private static $_instance = null;
        private static $_table = '';
        private static $_query = '';
        private static $_model = null;

        public function __construct(){
            parent::__construct();
            $this->Initialize();
        }

        /**
         * Insert data to a table in database
         * @param string migration name
         * @param array data to add
         */
        public function insertInto($migration,array $data){
            if(empty($migration))
                return false;
            
            if(empty($data))
                return false;
            $file = dirname(__FILE__) . '/../../Database/Migrations/' . $migration . '.php';
            if(file_exists($file))
            {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');
                if (class_exists($class))
                {
                    $table = new $class;
                    $table->handle();
                    $_data = array();
                    foreach($table->columns as $_col){
                        $col = new Column($_col);
                        $col->instance($_col['name'], $_col['options']);
                        if($col->isPrimary())
                            continue;
                        if($col->name == 'created_at' || $col->name == 'updated_at'){
                            $_data[$col->name] = date("Y-m-d H:i:s");
                            continue;
                        }
                        if(!array_key_exists($col->name, $data))
                            continue;
                        $_data[$col->name] = $data[$col->name];
                    }
                    $db_type = AutoLoad::env('DB_TYPE');
                    switch (strtolower($db_type)) {
                        case 'sqlite':
                            $insert = new SQLiteTable($this->pdo);
                            return $insert->insertToTable($table->name, $_data);
                        break;
                        case 'mysql':
                            $insert = new MySqlTable($this->pdo);
                            return $insert->insertToTable($table->name, $_data);
                        break;
                    }
                    
                }
            }
        }

        /**
         * Insert data to a table in database
         * @param string migration name
         * @param array id name and value
         * @param array data to add
         */
        public function update($migration, array $id,array $data){
            if(empty($migration))
                return false;
            
            if(empty($data))
                return false;
            $file = dirname(__FILE__) . '/../../Database/Migrations/' . $migration . '.php';
            if(file_exists($file))
            {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');
                if (class_exists($class))
                {
                    $table = new $class;
                    $table->handle();
                    $_data = array();
                    $db_type = AutoLoad::env('DB_TYPE');
                    foreach($table->columns as $_col){
                        $col = new Column($_col);
                        $col->instance($_col['name'], $_col['options']);
                        if($col->name == $id["name"])
                            continue;
                        if($col->name == 'updated_at'){
                            $_data[$col->name] = date("Y-m-d H:i:s");
                            continue;
                        }
                        if(!array_key_exists($col->name, $data))
                            continue;
                        $_data[$col->name] = $data[$col->name];
                    }
                    switch(strtolower($db_type)){
                        case 'slqlite':
                            $insert = new SQLiteTable($this->pdo);
                            return $insert->update($table->name, $id, $_data);
                        break;
                        case 'mysql':
                            $insert = new MySqlTable($this->pdo);
                            return $insert->update($table->name, $id, $_data);
                        break;
                    }
                }
            }
        }

        /**
         * Insert data to a table in database
         * @param string migration name
         * @param array id name and value
         * @param array data to add
         */
        public function getByIdColumn($migration, array $id){
            if(empty($migration))
                return false;
            
            if(empty($id))
                return false;
            $file = dirname(__FILE__) . '/../../Database/Migrations/' . $migration . '.php';
            if(file_exists($file))
            {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');
                if (class_exists($class))
                {
                    $table = new $class;
                    $table->handle();
                    $db_type = AutoLoad::env('DB_TYPE');
                    switch(strtolower($db_type)){
                        case 'slqlite':
                            $get = new SQLiteTable($this->pdo);
                            return $get->getByColumn($table->name, $id["name"], $id["value"]);
                        break;
                        case 'mysql':
                            $get = new MySqlTable($this->pdo);
                            return $get->getByColumn($table->name, $id["name"], $id["value"]);
                        break;
                    }
                    
                }
            }
        }

                /**
         * Insert data to a table in database
         * @param string migration name
         * @param array id name and value
         * @param array data to add
         */
        public function getByColumns($migration, array $columns){
            if(empty($migration))
                return false;
            
            if(empty($columns))
                return false;
            $file = dirname(__FILE__) . '/../../Database/Migrations/' . $migration . '.php';
            if(file_exists($file))
            {
                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');

                if (class_exists($class)) {
                    $table = new $class;
                    $table->handle();
                    $db_type = AutoLoad::env('DB_TYPE');
                }
                
                switch(strtolower($db_type)){
                    case 'slqlite':
                        $get = new SQLiteTable($this->pdo);
                        return $get->getByColumns($table->name, $columns);
                    break;
                    case 'mysql':
                        $get = new MySqlTable($this->pdo);
                        return $get->getByColumns($table->name, $columns);
                    break;
                }
            }
        }

        /**
         * Insert data to a table in database
         * @param string migration name
         * @param array id name and value
         * @param array data to add
         */
        public function delete($migration, array $id){
            if(empty($migration))
                return false;
            
            $file = dirname(__FILE__) . '/../../Database/Migrations/' . $migration . '.php';
            if(file_exists($file))
            {
                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');
                if (class_exists($class)) {
                    $table = new $class;
                    $table->handle();
                    $db_type = AutoLoad::env('DB_TYPE');
                
                    switch(strtolower($db_type)){
                        case 'slqlite':
                            $delete = new SQLiteTable($this->pdo);
                            return $delete->deleteRow($table->name, $id);
                        break;
                        case 'mysql':
                            $delete = new MySqlTable($this->pdo);
                            return $delete->deleteRow($table->name, $id);
                        break;
                    }
                }
            }
        }

        /**
         * Get a array of objects for a migration
         * @param string $migration name
         * @param numeric $limit the result
         * @param array $columns filter the results by columns
         */
        public function getList($migration, array $columns, $limit){
            if(empty($migration))
                return false;
            $file = dirname(__FILE__) . '/../../Database/Migrations/' . $migration . '.php';
            if(file_exists($file))
            {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');
                if (class_exists($class))
                {
                    $table = new $class;
                    $table->handle();
                    $db_type = AutoLoad::env('DB_TYPE');
                    $vars = get_object_vars($table);
                    $soft = false;
                    if (array_key_exists("deleted_at", $vars))
                        $soft = true;
                
                    switch(strtolower($db_type)){
                        case 'slqlite':
                            $get = new SQLiteTable($this->pdo);
                            return $get->getTable($table->name, $columns, $soft, $limit);
                        break;
                        case 'mysql':
                            $get = new MySqlTable($this->pdo);
                            return $get->getTable($table->name, $columns, $soft, $limit);
                        break;
                    };
                }
            }
        }

        /**
         * Execute a custom query
         * @param string $query query to execute
         */
        public static function query($query){
            if(empty($query))
                return false;
            $db_type = AutoLoad::env('DB_TYPE');
            switch(strtolower($db_type)){
                case 'slqlite':
                    $pdo = (new SQLiteConnection())->connect();
                    if ($pdo == null)
                        Log::print("SQLite Error : DB.php 291 line \n Whoops, could not connect to the SQLite database!");
                    $get = new SQLiteTable($pdo);
                    return $get->query($query);
                break;
                case 'mysql':
                    $pdo = (new MySqlConnection())->connect();
                    if ($pdo == null)
                        Log::print("MySql Error : DB.php 298 line \n Whoops, could not connect to the MySql database!");
                    $get = new MySqlTable($pdo);
                    return $get->query($query);
                break;
            }
        }

        /**
         * Init the PDO object for the database
         */
        private static function initPDO(){
            $db_type = AutoLoad::env('DB_TYPE');
            switch(strtolower($db_type)){
                case 'slqlite':
                    $pdo = (new SQLiteConnection())->connect();
                    if ($pdo == null){
                        Log::print("SQLite Error : DB.php 320 line \n Whoops, could not connect to the SQLite database!");
                        return null;
                    }
                    if (self::$_pdo === null) {
                        self::$_pdo = $pdo;
                    }
                break;
                case 'mysql':
                    $pdo = (new MySqlConnection())->connect();
                    if ($pdo == null) {
                        Log::print("MySql Error : DB.php 328 line \n Whoops, could not connect to the MySql database!");
                        return null;
                    }
                    if (self::$_pdo === null) {
                        self::$_pdo = $pdo;
                    }
                break;
            }
        }

        /**
         * Get the table name and model object to generate the query
         * also init the PDO object
         * @param string $name Model name
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public static function model($name){
            if(empty($name))
                return null;
            if (self::$_instance === null) {
                self::$_instance = new self;
            }
            self::initPDO();
            //get model and migration
            $m_file = dirname(__FILE__) . '/../../Models/' . $name . '.php';
            if (file_exists($m_file)) {
                require_once $m_file;
                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Models\\' . basename($m_file, '.php');
                if (class_exists($class))
                    self::$_model = new $class;
            }

            self::$_table = self::$_model->tableName();

            return self::$_instance;
        }

        /**
         * Get the table name to generate the query
         * also init the PDO object
         * @param string $name table name
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public static function table($name){
            if(empty($name))
                return null;
            if (self::$_instance === null) {
                self::$_instance = new self;
            }
            self::initPDO();
            self::$_table = $name;
            return self::$_instance;
        }

        /**
         * Get the select columns to add to query
         * @param array $columns names
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function select(array $columns=array()){
            if(empty(self::$_table) || is_null(self::$_instance))
                return null;

            self::$_query = " SELECT ";

            if(!empty($columns) && is_null(self::$_model)){
                foreach($columns as $col)
                    self::$_query .= " $col,";
                
                self::$_query = substr(self::$_query, 0, -1);
            }else
                self::$_query .= " * ";

            self::$_query .= " FROM " . self::$_table;

            return $this;
        }

        /**
         * Add where condition to the query
         * @param string $column names
         * @param string $value to test
         * @param string $condition to test with
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function where($column, $value, $condition="="){
            if(empty(self::$_table) || is_null(self::$_instance) || empty($column) || empty($value))
                return null;

            if(!strpos(self::$_query, "WHERE"))
                self::$_query .= " WHERE ";
            else
                self::$_query .= " AND ";
            
            self::$_query .= " $column $condition ";

            if(is_numeric($value))
                self::$_query .= " $value ";
            else if(is_string($value))
                self::$_query .= " '$value' ";
            
            
            return $this;
        }

        /**
         * Add a limit to the query
         * @param string $limit number
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function limit($limit){
            if(empty(self::$_table) || is_null(self::$_instance) || empty($limit))
                return null;

            if(!is_numeric($limit))
                return $this;
                
            if(!strpos(self::$_query, "LIMIT"))
                self::$_query .= " LIMIT $limit";
            
            return $this;
        }

        /**
         * Get only the first result, or a null
         * 
         * @return object
         */
        public function first(){
            if(empty(self::$_table) || is_null(self::$_instance))
                return null;

                
            if(!strpos(self::$_query, "LIMIT"))
                self::$_query .= " LIMIT 1";

            $data = array();

            $db_type = AutoLoad::env('DB_TYPE');
            switch(strtolower($db_type)){
                case 'slqlite':
                    $get = new SQLiteTable(self::$_pdo);
                    $data = $get->query(self::$_query);
                break;
                case 'mysql':
                    $get = new MySqlTable(self::$_pdo);
                    $data = $get->query(self::$_query);
                break;
            }

            if(!empty($data)){
                if(is_null(self::$_model))
                    return $data[0];
                $class = get_class(self::$_model);
                $obj = new $class();
                $class_vars = get_object_vars($obj);
                foreach($class_vars as $key => $value){
                    if (array_key_exists($key, $class_vars) && array_key_exists($key, $data[0]))
                        $obj->{$key} = $data[0][$key];
                }
                return $obj;
            }

            return null;
        }

        /**
         * Get all results
         * if a model is giving, a list of model objects are returned
         * if not, an array of data is returned
         * 
         * @return array
         */
        public function get(){
            if(empty(self::$_table) || is_null(self::$_instance))
                return null;

            $data = array();
            $db_type = AutoLoad::env('DB_TYPE');
            switch(strtolower($db_type)){
                case 'slqlite':
                    $get = new SQLiteTable(self::$_pdo);
                    $data = $get->query(self::$_query);
                break;
                case 'mysql':
                    $get = new MySqlTable(self::$_pdo);
                    $data = $get->query(self::$_query);
                break;
            }

            if(!empty($data)){
                if(is_null(self::$_model))
                    return $data;
                
                $objects = array();
                $class = get_class(self::$_model);
                foreach($data as $record){
                    $obj = new $class();
                    $class_vars = get_object_vars($obj);
                    foreach($class_vars as $key => $value){
                        if (array_key_exists($key, $class_vars) && array_key_exists($key, $record))
                            $obj->{$key} = $record[$key];
                    }
                    $objects[] =$obj;
                }
                return $objects;
            }

            return array();
        }
    }
}