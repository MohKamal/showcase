<?php
namespace  Showcase\Framework\Database\Config {
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framewok\IO\Debug\Log;
    
    class Column{

        public static function factory() {
            // The question is: How useful is this factory function. In fact: useless in
            // the current state, but it can be extended in any way
            return new self;
        }

        /**
         * Columns types
         * @var array
         */
        protected $types = array('DATETIME','INT', 'INTEGER', 'INT(1)', 'REAL', 'TEXT', 'BLOB');

        /**
         * Clean the column type every time the user call for a type function
         */
        private function clean(){
            $this->options = array_diff($this->options, $this->types);
        }

        /**
         * @var string table name
         */
        public $name = "column_name";

        /**
         * @var string type for model use's
         */
        public $PHP_type = "string";

        /**
         * @var bool primary column
         */
        public $PHP_autoIncrement = false;

        /**
         * Column options
         * @var array
         */
        public $options = array();

        public function __constructor(){
            $this->notnull();
        }

        /**
         * Instance column from array of existing options
         * @param string column name
         * @param array column options
         * @return \Showcase\Framework\Database\Config\Column
         */
        public function instance($name, array $options){
            $this->name($name);
            foreach($options as $opt){
                if($opt == "TEXT")
                    $this->string();
                else if($opt == 'INT')
                    $this->int();
                else if($opt == "INT(1)")
                    $this->bool();
                else if($opt == "TEXT")
                    $this->text();
                else if($opt == "BLOB")
                    $this->blob();
                else if($opt == "DATETIME")
                    $this->datetime();
                else if($opt=="NOT NULL")
                    $this->notnull();
                else if($opt == "NULL")
                    $this->nullable();
                else if($opt == "PRIMARY KEY")
                    $this->primary();
                else if($opt == "INTEGER")
                    $this->autoIncrement();
            }
            return $this;
        }

        /**
         * This column is string
         * @return \Framework\Database\Config\Column
         */
        public function string(){
            $type =  VarLoader::env('DB_TYPE');
            $this->clean();
            if(strtolower($type) == 'sqlite')
                array_push($this->options, 'TEXT');
            else if(strtolower($type) == 'mysql')
                array_push($this->options, "VARCHAR(250)");
            $this->PHP_type = "string";
            return $this;
        }

        /**
         * This column is int
         * @return \Framework\Database\Config\Column
         */
        public function int(){
            $this->clean();
            array_push($this->options, 'INT');
            $this->PHP_type = "int";
            return $this;
        }

        /**
         * This column is double
         * @return \Framework\Database\Config\Column
         */
        public function double(){
            $this->clean();
            array_push($this->options, 'REAL');
            $this->PHP_type = "double";
            return $this;
        }

        /**
         * This column is bool
         * @return \Framework\Database\Config\Column
         */
        public function bool(){
            $this->clean();
            $type =  VarLoader::env('DB_TYPE');
            if(strtolower($type) == 'sqlite')
                array_push($this->options, 'INT(1)');
            else if(strtolower($type) == 'mysql')
                array_push($this->options, 'TINYINT');
            $this->PHP_type = "bool";
            return $this;
        }

        /**
         * This column is blob
         * @return \Framework\Database\Config\Column
         */
        public function blob(){
            $this->clean();
            array_push($this->options, 'BLOB');
            $this->PHP_type = "string";
            return $this;
        }

        /**
         * This column is datetime
         * @return \Framework\Database\Config\Column
         */
        public function datetime(){
            $this->clean();
            array_push($this->options, 'DATETIME');
            $this->PHP_type = "string";
            return $this;
        }

        /**
         * This column is null
         * @return \Framework\Database\Config\Column
         */
        public function nullable(){            
            if(in_array('NOT NULL', $this->options))
                unset($this->options['NOT NULL']);
            array_push($this->options, 'NULL');
            return $this;
        }

        /**
         * This column is auto incremented
         * @return \Framework\Database\Config\Column
         */
        public function autoIncrement(){
            $this->clean();
            $db_type = VarLoader::env('DB_TYPE');
            switch(strtolower($db_type)){
                case 'sqlite':
                    array_push($this->options, 'INTEGER');
                    $this->PHP_autoIncrement = true;
                break;
                case 'mysql':
                    array_push($this->options, 'INT NOT NULL AUTO_INCREMENT');
                    $this->PHP_autoIncrement = true;
                break;
            }
            return $this;
        }

        /**
         * This column is primary
         * @return \Framework\Database\Config\Column
         */
        public function primary(){            
            array_push($this->options, 'PRIMARY KEY');
            return $this;
        }

        /**
         * Set the column name
         * @var string
         * @return \Framework\Database\Config\Column
         */
        public function name($name){
            if(!empty($name))
                $this->name = $name;
            return $this;
        }

        /**
         * This column is null
         * @return \Framework\Database\Config\Column
         */
        public function notnull(){
            if(in_array('NULL', $this->options))
                unset($this->options['NULL']);
            array_push($this->options, 'NOT NULL');
            return $this;
        }

        /**
         * This column is unique
         * @return \Framework\Database\Config\Column
         */
        public function unique(){
            array_push($this->options, 'UNIQUE');
            return $this;
        }

        /**
         * Set this column default value
         * @return \Framework\Database\Config\Column
         */
        public function default($value){
            if(!$value)
                return $this;
            array_push($this->options, "DEFAULT '" . $value . "'");
            return $this;
        }

        /**
         * Check if this columns is primary key
         * @return boolean
         */
        public function isPrimary(){
            return in_array('PRIMARY KEY', $this->options);
        }
    }
}