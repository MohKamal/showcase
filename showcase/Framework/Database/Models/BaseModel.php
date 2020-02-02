<?php
namespace Showcase\Framework\Database\Models {
    use \Showcase\Framework\Database\DB;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\Config\Column;
    
    class BaseModel{

        /**
         * Migration name for database uses
         * @var string
         */
        public $migration = "migration_name";

        /**
         * Database object
         * @var \Showcase\Framework\Database\DB
         */
        protected $db;

        /**
         * Create a property from the migration
         */
        private function createProperty($name, $value){
            $this->{$name} = $value;
        }

        /**
         * Init the model and create all properties
         */
        public function __construct(){
            $this->db = new DB();
            $file = dirname(__FILE__) . '\..\..\..\Database\Migrations\\' . $this->migration . '.php';
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
                    foreach($table->columns as $_col){
                        $col = new Column($_col);
                        if($col != null){
                            $value = 0;
                            if($col->PHP_type == "string")
                                $value = "";
                            else if($col->PHP_type == "bool")
                                $value = true;
                            $this->createProperty($col->name, $value);
                        }
                    }
                }
            }
        }

        /**
         * Setters
         */
        function __set($name,$value)
        {
            $this->{$name} = $value;
        }

        /**
         * Getters
         */
        function __get($name)
        {
            return $this->{$name};
        }

        public function save(){
            $class_vars = get_object_vars($this);
            $this->id = $this->db->insertInto($this->migration, $class_vars);
        }
    }
}