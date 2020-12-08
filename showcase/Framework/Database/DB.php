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
         * @param array $columns filter the results by columns
         */
        public function getList($migration, array $columns){
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
                            return $get->getTable($table->name, $columns, $soft);
                        break;
                        case 'mysql':
                            $get = new MySqlTable($this->pdo);
                            return $get->getTable($table->name, $columns, $soft);
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
    }
}