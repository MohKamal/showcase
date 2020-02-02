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
         * @var string migration name
         * @var array data to add
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
                        $col->name = $_col['name'];
                        if($col->isPrimary())
                            continue;
                        if(!array_key_exists($col->name, $data))
                            continue;
                        $_data[$col->name] = $data[$col->name];
                    }
                    $insert = new SQLiteTable($this->pdo);
                    return $insert->insertToTable($table->name, $_data);
                }
            }
        }
    }
}