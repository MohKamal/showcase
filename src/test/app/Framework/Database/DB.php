<?php
namespace  Showcase\Framework\Database {
    use \Showcase\Framework\Database\Wrapper;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\SQLite\SQLiteTable;
    use \Showcase\Framework\Database\MySql\MySqlTable;
    use \Showcase\Framework\Database\SQLite\SQLiteConnection;
    use \Showcase\Framework\Database\MySql\MySqlConnection;
    use \Showcase\Framework\Database\Config\Column;
    use \Showcase\Framework\Initializer\VarLoader;

    class DB extends Wrapper{

        private static $_pdo = null;
        private static $_instance = null;
        private static $_table = '';
        private static $_query = '';
        private static $_model = null;
        private static $_withTrash = false;

        public function __construct(){
            parent::__construct();
            $this->Initialize();
        }

        /**
         * Execute a custom query
         * @param string $query query to execute
         */
        public static function query($query){
            if(empty($query))
                return false;
            $db_type = VarLoader::env('DB_TYPE');
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
            $db_type = VarLoader::env('DB_TYPE');
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

            self::$_query = "SELECT ";

            if(!empty($columns) && is_null(self::$_model)){
                foreach($columns as $col)
                    self::$_query .= " $col,";
                
                self::$_query = substr(self::$_query, 0, -1);
            }else
                self::$_query .= " * ";

            self::$_query .= " FROM " . "`" . self::$_table . "`";

            return $this;
        }

        /**
         * Get the delete to query
         * @param array $columns names
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function delete(){
            if(empty(self::$_table) || is_null(self::$_instance))
                return null;

            self::$_query = "DELETE ";
            self::$_query .= " FROM " . "`" . self::$_table . "`";

            return $this;
        }

        /**
         * Set the columns to update to query
         * @param array $columns names and new values
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function insert(array $columns){
            if(empty(self::$_table) || is_null(self::$_instance) || empty($columns))
                return null;

            self::$_query = "INSERT INTO ";

            self::$_query .= "`" . self::$_table . "` (";

            foreach($columns as $key => $value){
                self::$_query .= "$key,";
            }
            self::$_query = substr(self::$_query, 0, -1);
            self::$_query .= ') VALUES (';
            foreach($columns as $key => $value){
                if(is_numeric($value))
                    self::$_query .= $this->filterInput($value) . ",";
                else if(is_string($value))
                    self::$_query .= "'" . str_replace("'", "", $this->filterInput($value)) . "',";
            }
            self::$_query = substr(self::$_query, 0, -1);
            self::$_query .= ')';

            return $this;
        }

        /**
         * Set the columns to update to query
         * @param array $columns names and new values
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function update(array $columns){
            if(empty(self::$_table) || is_null(self::$_instance) || empty($columns))
                return null;

            self::$_query = "UPDATE ";

            self::$_query .= "`" . self::$_table . "` SET ";

            foreach($columns as $key => $value){
                self::$_query .= " `$key`=";
                if(is_numeric($value))
                    self::$_query .= $value . ",";
                else if(is_string($value))
                    self::$_query .= "'" . str_replace("'", "", $this->filterInput($value)) . "',";
            }

            self::$_query = substr(self::$_query, 0, -1);

            return $this;
        }

        function filterInput($content)
        {
            $content = trim($content);
            $content = stripslashes($content);
            return $content;
        }

        //filter for viewing data
        function filterOutput($content)
        {
            $content = htmlentities($content, ENT_NOQUOTES);
            $content = nl2br($content, false);

            return $content;
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
            
            self::$_query .= " `$column`$condition";

            if(is_numeric($value))
                self::$_query .= "$value ";
            else if(is_string($value))
                self::$_query .= "'" . str_replace("'", "", $this->filterInput($value)) . "' ";
            
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
        public function orWhere($column, $value, $condition="="){
            if(empty(self::$_table) || is_null(self::$_instance) || empty($column) || empty($value))
                return null;

            if(!strpos(self::$_query, "WHERE"))
                self::$_query .= " WHERE ";
            else
                self::$_query .= " OR ";
            
            self::$_query .= " `$column`$condition";

            if(is_numeric($value))
                self::$_query .= "$value ";
            else if(is_string($value))
                self::$_query .= "'" . str_replace("'", "", $this->filterInput($value)) . "' ";
            
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
         * Get count
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function count($column="*"){
            if(empty(self::$_table) || is_null(self::$_instance))
                return null;
            if (strpos(self::$_query, "SELECT") !== false) {
                $search = "#(SELECT).*?(FROM)#";
                $replace = '$1' . " COUNT($column) " . '$2';
                self::$_query = preg_replace($search, $replace, self::$_query);
            }
            return $this;
        }

        /**
         * Add Destinct condition
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function distinct($column=""){
            if(empty(self::$_table) || is_null(self::$_instance))
                return null;
            if(strpos(self::$_query, "SELECT") !== false)
                self::$_query = str_replace("SELECT", "SELECT DISTINCT $column", self::$_query);
            return $this;
        }

        /**
         * Check for soft delete columns to add/remove them from the result
         */
        private function soft(){
            if(!is_null(self::$_model)){
                if(!self::$_withTrash){
                    if (property_exists(self::$_model, 'deleted_at')) {
                        if(!strpos(self::$_query, "WHERE"))
                            self::$_query .= " WHERE ";
                        else
                            self::$_query .= " AND ";

                        self::$_query .= "`deleted_at` IS null AND `active`=1";
                    }
                }
            }
        }

        /**
         * Add trashed rows, if soft delete is activated
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function withTrash(){
            self::$_withTrash = true;

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

            $this->soft();
                
            if(!strpos(self::$_query, "LIMIT"))
                self::$_query .= " LIMIT 1";
            
            $data = array();
            $db_type = VarLoader::env('DB_TYPE');
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
                        $obj->{$key} = $this->filterOutput($data[0][$key]);
                }
                return $obj;
            }

            return null;
        }

               /**
         * Get only the first result, or a null
         * 
         * @return object
         */
        public function run(){
            if(empty(self::$_table) || is_null(self::$_instance))
                return null;
            $db_type = VarLoader::env('DB_TYPE');
            switch(strtolower($db_type)){
                case 'slqlite':
                    $get = new SQLiteTable(self::$_pdo);
                    return $get->query(self::$_query);
                break;
                case 'mysql':
                    $get = new MySqlTable(self::$_pdo);
                    return $get->query(self::$_query);
                break;
            }
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
            //check for soft delete
            $this->soft();
            $data = array();
            $db_type = VarLoader::env('DB_TYPE');
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
                            $obj->{$key} = $this->filterOutput($record[$key]);
                    }
                    $objects[] =$obj;
                }
                return $objects;
            }

            return array();
        }
    }
}