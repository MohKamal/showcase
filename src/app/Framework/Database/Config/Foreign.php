<?php
namespace  Showcase\Framework\Database\Config {
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framewok\IO\Debug\Log;
    use \Showcase\Framework\HTTP\Exceptions\DatabaseException;
    use \Showcase\Framework\HTTP\Exceptions\ExecptionEnum;
    
    class Foreign{

        public static function factory() {
            // The question is: How useful is this factory function. In fact: useless in
            // the current state, but it can be extended in any way
            return new self;
        }

        /**
         * @var string column name
         */
        public $current_table_column_name = '';

        /**
         * @var string table name
         */
        public $foreign_table_name = '';

        /**
         * @var string table name
         */
        public $foreign_middle_table_name = '';

        /**
         * @var string table name
         */
        public $foreign_middle_table_current_column = '';

        /**
         * @var string foreign table column name
         */
        public $foreign_table_column_name = '';

        /**
         * @var string model name
         */
        public $foreign_model_name = '';

        /**
         * @var string model column name
         */
        public $foreign_model_column_name = '';

        /**
         * @var string calling method alias name
         */
        public $method_alias = '';

        /**
         * @var bool if true it return only one object, if false it return array of objects
         */
        public $one_object_to_return = true;

        /**
         * @var string on cascade
         */
        public $on_cascade = '';

        /**
         * @var bool add it to query
         */
        public $add_to_query = true;

        /**
         * The column name that will be a foreign key
         * @param string $name table column name
         * @return \Framework\Database\Config\Foreign
         */
        public function column(string $name) {
            if (empty($name)) {
                throw new DatabaseException('Foreign column was not define', ExecptionEnum::NULL_VALUE);
            }
            $this->current_table_column_name = $name;
            return $this;
        }

        /**
         * The table and column in the foreign table
         * @param string $table foreign table name
         * @param string $column foreign table column name
         * @return \Framework\Database\Config\Foreign
         */
        public function on(string $table, string $column = 'id') {
            if(empty($table) && empty($column)) {
                throw new DatabaseException('Foreign table or column was not define', ExecptionEnum::NULL_VALUE);
            }
            $this->foreign_table_name = $table;
            $this->foreign_table_column_name = $column;
            return $this;
        }

        /**
         * Add the on update cascade to the foreign key
         * @return \Framework\Database\Config\Foreign
         */
        public function updateCascade() {
            $this->on_cascade = 'ON UPDATE CASCADE';
            return $this;
        }

        /**
         * Add the on delete cascade to the foreign key
         * @return \Framework\Database\Config\Foreign
         */
        public function deleteCascade() {
            $this->on_cascade = 'ON DELETE CASCADE';
            return $this;
        }

        /**
         * Don't add this constaint to the query
         * @return \Framework\Database\Config\Foreign
         */
        public function dontAddItToQuery() {
            $this->add_to_query = false;
            return $this;
        }

        /**
         * Set method alias to call from an model object
         * @param string $name method alias
         * @return \Framework\Database\Config\Foreign
         */
        public function alias($name) {
            if (empty($name)) {
                throw new DatabaseException('No correct alias was giving', ExecptionEnum::NULL_VALUE);
            }
            $this->method_alias = $name;
            return $this;
        }

        /**
         * Get the table name and model object to generate the query
         * @param string $name Model name
         * 
         * @return \Framework\Database\Config\Foreign
         */
        public function model($name) {
            if(empty($name))
                throw new DatabaseException('No correct model name was giving', ExecptionEnum::NULL_VALUE);

            //vertify model
            $m_file = dirname(__FILE__) . '/../../../Models/' . $name . '.php';
            if (file_exists($m_file)) {
                require_once $m_file;
                // get the file name of the current file without the extension
                // which is essentially the class name
                $class = '\Showcase\Models\\' . basename($m_file, '.php');
                if (class_exists($class)) {
                    $this->foreign_model_name = $name;
                } else {
                    throw new DatabaseException('Model class was not found', ExecptionEnum::MODEL_NOT_FOUND);
                }
            } else {
                throw new DatabaseException('Model file was not found', ExecptionEnum::MODEL_NOT_FOUND);
            }

            return $this;
        }

        /**
         * Get array of object of the method
         * @return \Framework\Database\Config\Foreign
         */
        public function many() {
            $this->one_object_to_return = false;
            return $this;
        }

        /**
         * Connect model to another with middle table
         * @param string $table middle table
         * @param string $current_object_column current model id in the middle table (user_id)
         * @param string $foreign_object_column foreign model id in the middle table (role_id)
         * 
         * @return \Framework\Database\Config\Foreign
         */
        public function toOne(string $table, string $current_object_column, string $foreign_object_column) {
            $this->one_object_to_return = true;
            if(empty($table)) {
                throw new DatabaseException('Middle table name was not giving', ExecptionEnum::NULL_VALUE);
            }

            if(empty($current_object_column)) {
                throw new DatabaseException('Current migration column was not giving', ExecptionEnum::NULL_VALUE);
            }

            if(empty($foreign_object_column)) {
                throw new DatabaseException('Foreign migration column was not giving', ExecptionEnum::NULL_VALUE);
            }

            $this->foreign_middle_table_name = $table;
            $this->foreign_middle_table_current_column = $current_object_column;
            $this->foreign_model_column_name = $foreign_object_column;

            return $this;
        }

        /**
         * Connect model to another with middle table
         * @param string $table middle table
         * @param string $current_object_column current model id in the middle table (user_id)
         * @param string $foreign_object_column foreign model id in the middle table (role_id)
         * 
         * @return \Framework\Database\Config\Foreign
         */
        public function toMany(string $table, string $current_object_column, string $foreign_object_column) {
            $this->one_object_to_return = false;
            if(empty($table)) {
                throw new DatabaseException('Middle table name was not giving', ExecptionEnum::NULL_VALUE);
            }

            if(empty($current_object_column)) {
                throw new DatabaseException('Current migration column was not giving', ExecptionEnum::NULL_VALUE);
            }

            if(empty($foreign_object_column)) {
                throw new DatabaseException('Foreign migration column was not giving', ExecptionEnum::NULL_VALUE);
            }
            
            $this->foreign_middle_table_name = $table;
            $this->foreign_middle_table_current_column = $current_object_column;
            $this->foreign_model_column_name = $foreign_object_column;

            return $this;
        }
    }
}