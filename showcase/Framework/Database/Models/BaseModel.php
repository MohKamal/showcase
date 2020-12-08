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
         * Id information for database requests
         * @var array
         */
        protected $idDetails = array();

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
            $file = dirname(__FILE__) . '/../../../Database/Migrations/' . $this->migration . '.php';
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
                        $col = new Column();
                        $col->instance($_col['name'], $_col['options']);
                        if($col != null){
                            $value = 0;
                            if($col->PHP_type == "string")
                                $value = "";
                            else if($col->PHP_type == "bool")
                                $value = true;

                            if($col->isPrimary())
                                $this->idDetails["name"] = $col->name;
                            $this->createProperty($col->name, $value);
                        }
                    }
                }
            }
        }

        /**
         * Get an object by id
         * @param mixte id value
         * @return \Showcase\Framework\Database\Models\BaseModel
         */
        public function get($id){
            $record = $this->db->getByIdColumn($this->migration, ["name" => $this->idDetails["name"], "value" => $id]);
            if($record != null){
                $class_vars = get_object_vars($this);
                foreach($class_vars as $key => $value){
                    if(array_key_exists($key, $record)){
                        $this->{$key} = $record[$key];
                        if($key == $this->idDetails["name"])
                           $this->idDetails["value"] =  $record[$key];
                    }
                }
            }
            return $this;
        }

        /**
         * Get an object by id
         * @param mixte id value
         * @return \Showcase\Framework\Database\Models\BaseModel
         */
        public function where(array $params){
            $record = $this->db->getByColumns($this->migration, $params);
            if($record != null){
                $class_vars = get_object_vars($this);
                foreach($class_vars as $key => $value){
                    if(array_key_exists($key, $record)){
                        $this->{$key} = $record[$key];
                        if($key == $this->idDetails["name"])
                           $this->idDetails["value"] =  $record[$key];
                    }
                }
            }
            return $this;
        }

        /**
         * Setters
         * @param string property name
         * @param Mixte property value
         */
        function __set($name,$value)
        {
            if(array_key_exists("name", $this->idDetails)){
                if($this->{$name} == $this->idDetails["name"])
                    $this->idDetails["value"] = $value;
            }
            $this->{$name} = $value;
        }

        /**
         * Getters
         * @param string property name
         * @return Mixte
         */
        function __get($name)
        {
            if (isset($this->{$name}))
                return $this->{$name};
        }

        /**
         * Save/Update to database
         * @return \Showcase\Framework\Database\Models\BaseModel
         */
        public function save(){
            $class_vars = get_object_vars($this);
            if(!array_key_exists("value", $this->idDetails))
                $this->{$this->idDetails["name"]} = $this->db->insertInto($this->migration, $class_vars);
            else
                $this->db->update($this->migration, $this->idDetails, $class_vars);

            return $this;
        }

        /**
         * Delete an \Showcase\Framework\Database\Models\BaseModel
         * @return int count
         */
        public function delete(){
            $class_vars = get_object_vars($this);
            if (array_key_exists("deleted_at", $class_vars)){
                $this->deleted_at = date("Y-m-d H:i:s");
                $this->active = 0;
                $class_vars = get_object_vars($this);
                $this->db->update($this->migration, $this->idDetails, $class_vars);
            }else{
                return $this->db->delete($this->migration, $this->idDetails);
            }
        }

        /**
         * Get list of this model
         * @return array \Showcase\Framework\Database\Models\BaseModel
         */
        public static function toList(array $columns=array()){
            $class = get_called_class();
            $model = new $class();
            $db = new DB();
            $records = $db->getList($model->migration, $columns);
            if(count($records) > 0){
                $data = array();
                foreach($records as $record){
                    $obj = new $class();
                    $class_vars = get_object_vars($obj);
                    foreach($class_vars as $key => $value){
                        if (array_key_exists($key, $class_vars) && array_key_exists($key, $record))
                            $obj->{$key} = $record[$key];
                    }
                    $data[] =$obj;
                }
                return $data;
            }
            return array();
        }

        /**
         * Hash string, can be used for password
         */
        public function bcrypt($password){
            $options = [
                'cost' => 12,
            ];
            $this->password = password_hash($password, PASSWORD_BCRYPT, $options);
        }

        /**
         * Check if the hash is correcte
         */
        public function validHash($password, $hash){
            return password_verify($password, $hash);
        }
    }
}