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

        private $_pdo = null;
        private static $_instance = null;
        private $_table = '';
        private $_query = '';
        private $_model = null;
        private $_withTrash = false;

        public function __construct(){
            parent::__construct();
            $this->Initialize();
        }

        public static function factory(){
            self::$_instance = new self;
            return self::$_instance;
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
                case 'sqlite':
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
        private function initPDO(){
            $this->_table = '';
            $this->_query = '';
            $this->_model = null;
            $db_type = VarLoader::env('DB_TYPE');
            switch(strtolower($db_type)){
                case 'sqlite':
                    $pdo = (new SQLiteConnection())->connect();
                    if ($pdo == null){
                        Log::print("SQLite Error : DB.php 320 line \n Whoops, could not connect to the SQLite database!");
                        return null;
                    }
                    if ($this->_pdo === null) {
                        $this->_pdo = $pdo;
                    }
                break;
                case 'mysql':
                    $pdo = (new MySqlConnection())->connect();
                    if ($pdo == null) {
                        Log::print("MySql Error : DB.php 328 line \n Whoops, could not connect to the MySql database!");
                        return null;
                    }
                    if ($this->_pdo === null) {
                        $this->_pdo = $pdo;
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
        public function model($name){
            if(empty($name))
                return null;
            
            $this->initPDO();
            //get model and migration
            $m_file = dirname(__FILE__) . '/../../Models/' . $name . '.php';
            if (file_exists($m_file)) {
                require_once $m_file;
                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Models\\' . basename($m_file, '.php');
                if (class_exists($class))
                    $this->_model = new $class;
            }

            $this->_table = $this->_model->tableName();

            return $this;
        }

        /**
         * Get the table name to generate the query
         * also init the PDO object
         * @param string $name table name
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function table($name){
            if(empty($name))
                return null;
            $this->initPDO();
            $this->_table = $name;
            return $this;
        }

        /**
         * Get the select columns to add to query
         * @param array $columns names
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function select(array $columns=array()){
            if(empty($this->_table) || is_null(self::$_instance))
                return null;

                $this->_query = "SELECT ";

            if(!empty($columns) && is_null($this->_model)){
                foreach($columns as $col)
                $this->_query .= " $col,";
                
                $this->_query = substr($this->_query, 0, -1);
            }else
            $this->_query .= " * ";

            $this->_query .= " FROM " . "`" . $this->_table . "`";

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

            $this->_query = "DELETE ";
            $this->_query .= " FROM " . "`" . $this->_table . "`";

            return $this;
        }

        /**
         * Set the columns to update to query
         * @param array $columns names and new values
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function insert(array $columns){
            if(empty($this->_table) || is_null(self::$_instance) || empty($columns))
                return null;

            $this->_query = "INSERT INTO ";

            $this->_query .= "`" . $this->_table . "` (";

            foreach($columns as $key => $value){
                $this->_query .= "$key,";
            }
            $this->_query = substr($this->_query, 0, -1);
            $this->_query .= ') VALUES (';
            foreach($columns as $key => $value){
                if(is_null($value))
                    $this->_query .= "NULL,";
                else if(is_numeric($value))
                    $this->_query .= $this->filterInput($value) . ",";
                else if(is_string($value))
                    $this->_query .= "'" . str_replace("'", "", $this->filterInput($value)) . "',";
            }
            $this->_query = substr($this->_query, 0, -1);
            $this->_query .= ')';

            return $this;
        }

        /**
         * Set the columns to update to query
         * @param array $columns names and new values
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function update(array $columns){
            if(empty($this->_table) || is_null(self::$_instance) || empty($columns))
                return null;

            $this->_query = "UPDATE ";

            $this->_query .= "`" . $this->_table . "` SET ";

            foreach($columns as $key => $value){
                $this->_query .= " `$key`=";
                if(is_numeric($value))
                    $this->_query .= $value . ",";
                else if(is_string($value))
                    $this->_query .= "'" . str_replace("'", "", $this->filterInput($value)) . "',";
            }

            $this->_query = substr($this->_query, 0, -1);

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
         * Add a raw sql query
         * @param string $query sql
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function raw($query){
            if(empty($this->_table) || is_null(self::$_instance) || empty($query))
                return null;

            $this->_query .= $query;
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
            if(empty($this->_table) || is_null(self::$_instance) || empty($column) || empty($value))
                return null;

            if(!strpos($this->_query, "WHERE"))
                $this->_query .= " WHERE ";
            else
                $this->_query .= " AND ";
            
            $this->_query .= " `$column`$condition";

            if(is_numeric($value))
                $this->_query .= "$value ";
            else if(is_string($value))
                $this->_query .= "'" . str_replace("'", "", $this->filterInput($value)) . "' ";
            
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
            if(empty($this->_table) || is_null(self::$_instance) || empty($column) || empty($value))
                return null;

            if(!strpos($this->_query, "WHERE"))
                $this->_query .= " WHERE ";
            else
                $this->_query .= " OR ";
            
            $this->_query .= " `$column`$condition";

            if(is_numeric($value))
                $this->_query .= "$value ";
            else if(is_string($value))
                $this->_query .= "'" . str_replace("'", "", $this->filterInput($value)) . "' ";
            
            return $this;
        }

        /**
         * Add a limit to the query
         * @param string $limit number
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function limit($limit){
            if(empty($this->_table) || is_null(self::$_instance) || empty($limit))
                return null;

            if(!is_numeric($limit))
                return $this;
                
            if(!strpos($this->_query, "LIMIT"))
                $this->_query .= " LIMIT $limit";
            
            return $this;
        }

        /**
         * Get count
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function count($column="*"){
            if(empty($this->_table) || is_null(self::$_instance))
                return null;
            if (strpos($this->_query, "SELECT") !== false) {
                $search = "#(SELECT).*?(FROM)#";
                $replace = '$1' . " COUNT($column) " . '$2';
                $this->_query = preg_replace($search, $replace, $this->_query);
            }
            return $this;
        }

        /**
         * Add Destinct condition
         * 
         * @return \Showcase\Framework\Database\DB
         */
        public function distinct($column=""){
            if(empty($this->_table) || is_null(self::$_instance))
                return null;
            if(strpos($this->_query, "SELECT") !== false)
                $this->_query = str_replace("SELECT", "SELECT DISTINCT $column", $this->_query);
            return $this;
        }

        /**
         * Check for soft delete columns to add/remove them from the result
         */
        private function soft(){
            if(!is_null($this->_model)){
                if(!$this->_withTrash){
                    if (property_exists($this->_model, 'deleted_at')) {
                        if(!strpos($this->_query, "WHERE"))
                            $this->_query .= " WHERE ";
                        else
                            $this->_query .= " AND ";

                        $this->_query .= "`deleted_at` IS null AND `active`=1";
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
            $this->_withTrash = true;

            return $this;
        }

        /**
         * Get only the first result, or a null
         * 
         * @return object
         */
        public function first(){
            if(empty($this->_table) || is_null(self::$_instance))
                return null;

            $this->soft();
                
            if(!strpos($this->_query, "LIMIT"))
                $this->_query .= " LIMIT 1";
            
            $data = array();
            $db_type = VarLoader::env('DB_TYPE');
            switch(strtolower($db_type)){
                case 'sqlite':
                    $get = new SQLiteTable($this->_pdo);
                    $data = $get->query($this->_query);
                break;
                case 'mysql':
                    $get = new MySqlTable($this->_pdo);
                    $data = $get->query($this->_query);
                break;
            }

            if(!empty($data)){
                if(is_null($this->_model))
                    return $data[0];
                $class = get_class($this->_model);
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
            if(empty($this->_table) || is_null(self::$_instance))
                return null;
            $db_type = VarLoader::env('DB_TYPE');
            switch(strtolower($db_type)){
                case 'sqlite':
                    $get = new SQLiteTable($this->_pdo);
                    return $get->query($this->_query);
                break;
                case 'mysql':
                    $get = new MySqlTable($this->_pdo);
                    return $get->query($this->_query);
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
            if(empty($this->_table) || is_null(self::$_instance))
                return null;
            //check for soft delete
            $this->soft();
            $data = array();
            $db_type = VarLoader::env('DB_TYPE');
            switch(strtolower($db_type)){
                case 'sqlite':
                    $get = new SQLiteTable($this->_pdo);
                    $data = $get->query($this->_query);
                break;
                case 'mysql':
                    $get = new MySqlTable($this->_pdo);
                    $data = $get->query($this->_query);
                break;
            }

            if(!empty($data)){
                if(is_null($this->_model))
                    return $data;
                
                $objects = array();
                $class = get_class($this->_model);
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