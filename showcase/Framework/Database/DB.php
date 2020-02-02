<?php
namespace Showcase\Framework\Database {
    use \Showcase\Framework\Database\Wrapper;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\SQLite\SQLiteTable;
    use \Showcase\Framework\Database\Config\Column;
    use \Showcase\Framework\Database\Config\Converter;

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
            $file = dirname(__FILE__) . '\..\..\Database\Migrations\\' . $migration . '.php';
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
                    $insert = new SQLiteTable($this->pdo);
                    return $insert->insertToTable($table->name, $_data);
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
            $file = dirname(__FILE__) . '\..\..\Database\Migrations\\' . $migration . '.php';
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
                    $insert = new SQLiteTable($this->pdo);
                    return $insert->update($table->name, $id, $_data);
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
            $file = dirname(__FILE__) . '\..\..\Database\Migrations\\' . $migration . '.php';
            if(file_exists($file))
            {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');
                if (class_exists($class))
                {
                    $table = new $class;
                    $get = new SQLiteTable($this->pdo);
                    return $get->getByColumn($migration, $id["name"], $id["value"]);
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
            $file = dirname(__FILE__) . '\..\..\Database\Migrations\\' . $migration . '.php';
            if(file_exists($file))
            {
                $get = new SQLiteTable($this->pdo);
                return $get->getByColumns($migration, $columns);
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
            
            $file = dirname(__FILE__) . '\..\..\Database\Migrations\\' . $migration . '.php';
            if(file_exists($file))
            {
                $delete = new SQLiteTable($this->pdo);
                return $delete->deleteRow($migration, $id);
            }
        }

        public function getList($migration){
            if(empty($migration))
                return false;
            $file = dirname(__FILE__) . '\..\..\Database\Migrations\\' . $migration . '.php';
            if(file_exists($file))
            {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');
                if (class_exists($class))
                {
                    $table = new $class;
                    $vars = get_object_vars($table);
                    $soft = false;
                    if (array_key_exists("deleted_at", $vars))
                        $soft = true;
                    $get = new SQLiteTable($this->pdo);
                    return $get->getTable($migration, $soft);
                }
            }
        }
    }
}