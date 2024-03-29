<?php
namespace  Showcase\Framework\Database\Models {
    use \Showcase\Framework\Database\DB;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\Config\Column;
    use \Showcase\Framework\IO\Storage\Storage;
    use \Showcase\Framework\HTTP\Exceptions\ModelException;
    use \Showcase\Framework\HTTP\Exceptions\ExecptionEnum;
    
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
         * Don't search for those vars in database
         * @var array
         */
        public $variables = array();

        /**
         * Create a property from the migration
         */
        private function createProperty($name, $value){
            $this->{$name} = $value;
        }

        /**
         * Ge the id variable Name
         * @return string $name
         */
        public function getIdName() {
            return $this->idDetails['name'];
        }

        /**
         * Init the model and create all properties
         */
        public function __construct(){
            $this->initializeTable();
        }

        /**
         * Create this model propeties and methods from the migrations
         * @param bool $runForeign verify foreign relation and create their methods
         */
        private function initializeTable(bool $runForeign = true) {
            $file = Storage::migrations()->path($this->migration . '.php');
            if($file !== false)
            {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');
                if (class_exists($class))
                {
                    $table = new $class;
                    $table->handle();
                    if($runForeign)
                        $table->handleForeign();
                    foreach($table->columns as $_col) {
                        $col = new Column();
                        $col->instance($_col['name'], $_col['options']);
                        if($col != null) {
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

                    foreach($table->foreigns as $foreign) {
                        if($foreign !== null) {
                            $methodName = '';
                            $setterName = '';
                            $value = function() {};
                            $setter = null;
                            if (!empty($foreign->foreign_model_name)) {
                                $methodName = strtolower($foreign->foreign_model_name);
                                $setterName = 'set' . ucfirst(strtolower($foreign->foreign_model_name));
                                if(!$foreign->one_object_to_return)
                                    $methodName = $methodName . 's';

                                if (empty($foreign->foreign_middle_table_name)) {
                                    $value = function () use ($foreign) {
                                        $qb = DB::factory()->model($foreign->foreign_model_name)->select()->where($foreign->foreign_table_column_name, $this->{$foreign->current_table_column_name});
                                        if($foreign->one_object_to_return)
                                            return $qb->first();
                                        return $qb->get();
                                    };
                                    
                                    $setter = function ($arg) use ($foreign) {
                                        $foreignModel = $arg[0];
                                        $this->{$foreign->current_table_column_name} = $foreignModel->{$foreignModel->getIdName()};
                                        if(!empty($this->{$this->idDetails["name"]}))
                                            $this->save();
                                    };
                                } else {
                                    $value = function () use ($foreign) {
                                        $query = 'SELECT * FROM ' . $foreign->foreign_table_name . ' WHERE ' . $foreign->foreign_table_column_name . ' IN ' . '(SELECT ' . $foreign->foreign_model_column_name . ' FROM ' . $foreign->foreign_middle_table_name . ' WHERE ' . $foreign->foreign_middle_table_current_column . '=' . $this->{$this->getIdName()} . ')'; 
                                        $qb = DB::factory()->model($foreign->foreign_model_name)->query($query);
                                        if($foreign->one_object_to_return)
                                            return $qb->first();
                                        return $qb->get();
                                    };
                                    
                                    $setter = function ($arg) use ($foreign) {
                                        $foreignModel = $arg[0];
                                        $values = [
                                            $foreign->foreign_model_column_name => $foreignModel->{$foreignModel->getIdName()},
                                            $foreign->foreign_middle_table_current_column => $this->{$this->getIdName()},
                                            'created_at' => date("Y-m-d H:i:s"),
                                            'updated_at' => date("Y-m-d H:i:s")
                                        ];
                                        DB::factory()->table($foreign->foreign_middle_table_name)->insert($values)->run();
                                    };
                                }
                            } else if(!empty($foreign->foreign_table_name)) {
                                $value = function () use ($foreign) {
                                    $qb = DB::factory()->table($foreign->foreign_table_name)->select()->where($foreign->foreign_table_column_name, $this->{$foreign->current_table_column_name});
                                    if($foreign->one_object_to_return)
                                        return $qb->first();
                                    return $qb->get();
                                };
                            }

                            if(!empty($foreign->method_alias)) {
                                $methodName = $foreign->method_alias;
                            }
                            
                            $this->createProperty($methodName, $value);
                            if($setter !== null) { $this->createProperty($setterName, $setter); }
                        }
                    }
                } else {
                    throw new ModelException('Migration class was not found, please check the migration file name and it\'s class name.', ExecptionEnum::MIGRATION_NOT_FOUND);
                }
            } else {
                throw new ModelException('Migration file was not found, please check the model migration name.', ExecptionEnum::MIGRATION_NOT_FOUND);
            }
        }

        /**
         * Call dynamic method
         * @param string $name method name
         * @param array $arguments method arguments
         * 
         * @return Mixte
         */
        public function __call($name, $arguments)
        {
            try {
                return call_user_func($this->{$name}, $arguments);
            }catch(\Exception $e) {
                throw new ModelException($e->getMessage(), ExecptionEnum::CUSTOM);
            }
        }

        /**
         * Get the migration table name
         * 
         * @return string table name
         */
        public function tableName(){
            $file = Storage::migrations()->path($this->migration . '.php');
            if($file !== false)
            {
                require_once $file;

                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Database\Migrations\\' . basename($file, '.php');
                if (class_exists($class))
                {
                    $table = new $class;
                    $table->handle();
                    return $table->name;
                }
            }

            return '';
        }

        /**
         * Get the class name
         * 
         * @return string
         */
        public function className(){
            $reflect = new \ReflectionClass($this);
            return $reflect->getShortName();
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
            if(empty($class_vars)) {
                throw new ModelException('No property or method was found for ' . $this->className(), ExecptionEnum::NO_PROPERTY_FOUND);
            }
            if(empty($this->{$this->idDetails["name"]})){
                if(array_key_exists('created_at', $class_vars) && array_key_exists('updated_at', $class_vars)){
                    $this->created_at = date("Y-m-d H:i:s");
                    $this->updated_at = date("Y-m-d H:i:s");
                }
                if (array_key_exists("deleted_at", $class_vars)) {
                    $this->active = 1;
                    $this->deleted_at = null;
                }

                $class_vars = get_object_vars($this);
                unset($class_vars['migration']);
                unset($class_vars['idDetails']);
                unset($class_vars['db']);
                foreach($this->variables as $variable)
                    unset($class_vars[$variable]);
                unset($class_vars['variables']);

                foreach($class_vars as $key => $value) {
                    if(is_callable($this->{$key})) 
                        unset($class_vars[$key]);
                }

                $this->{$this->idDetails["name"]} = DB::factory()->model($this->className())->insert($class_vars)->run();
            }else{
                $this->updated_at = date("Y-m-d H:i:s");
                unset($class_vars['migration']);
                unset($class_vars['idDetails']);
                unset($class_vars['db']);
                foreach($this->variables as $variable)
                    unset($class_vars[$variable]);
                unset($class_vars['variables']);

                foreach($class_vars as $key => $value) {
                    if(is_callable($this->{$key})) 
                        unset($class_vars[$key]);
                }

                DB::factory()->model($this->className())->update($class_vars)->where($this->idDetails["name"], $this->{$this->idDetails["name"]})->run();
            }
            return $this;
        }

        /**
         * Delete an \Showcase\Framework\Database\Models\BaseModel
         * @return int count
         */
        public function delete(){
            $class_vars = get_object_vars($this);
            if(empty($class_vars)) {
                throw new ModelException('No property or method was found for ' . $this->className(), ExecptionEnum::NO_PROPERTY_FOUND);
            }
            if (array_key_exists("deleted_at", $class_vars)){
                $this->deleted_at = date("Y-m-d H:i:s");
                $this->active = 0;
                $class_vars = get_object_vars($this);
                unset($class_vars['migration']);
                unset($class_vars['idDetails']);
                unset($class_vars['db']);
                foreach($this->variables as $variable)
                    unset($class_vars[$variable]);
                unset($class_vars['variables']);
                    
                return DB::factory()->model($this->className())->update($class_vars)->where($this->idDetails["name"], $this->{$this->idDetails["name"]})->run();
            }
            else
                return DB::factory()->model($this->className())->delete()->where($this->idDetails["name"], $this->{$this->idDetails["name"]})->run();
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

        /**
         * Get the json of this object
         * With removing the hidden properties
         * @return json
         */
        public function toJson(){
            $obj = $this;
            unset($obj->migration);
            unset($obj->idDetails);
            unset($obj->db);
            return json_encode($obj);
        }

        /**
         * Get this object as array
         * With removing the hidden properties
         * @return array
         */
        public function toArray(){
            $obj = $this;
            unset($obj->migration);
            unset($obj->idDetails);
            unset($obj->db);
            return (array)$obj;
        }
    }
}