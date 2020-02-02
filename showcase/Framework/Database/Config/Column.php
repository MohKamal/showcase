<?php
namespace Showcase\Framework\Database\Config {
    use \Showcase\AutoLoad;
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
        protected $types = array('VARACHAR', 'INT', 'INTEGER', 'tinyint', 'double', 'float', 'text', 'blob');

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
        public $PHP_primary = false;

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
         * This column is string
         * @return \Framework\Database\Config\Column
         */
        public function string(){
            $this->clean();
            array_push($this->options, 'VARACHAR');
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
            array_push($this->options, 'double');
            $this->PHP_type = "double";
            return $this;
        }

        /**
         * This column is float
         * @return \Framework\Database\Config\Column
         */
        public function float(){
            $this->clean();
            array_push($this->options, 'float');
            $this->PHP_type = "float";
            return $this;
        }

        /**
         * This column is bool
         * @return \Framework\Database\Config\Column
         */
        public function bool(){
            $this->clean();
            array_push($this->options, 'tinyint');
            $this->PHP_type = "bool";
            return $this;
        }

        /**
         * This column is text
         * @return \Framework\Database\Config\Column
         */
        public function text(){
            $this->clean();
            array_push($this->options, 'text');
            $this->PHP_type = "string";
            return $this;
        }

        /**
         * This column is blob
         * @return \Framework\Database\Config\Column
         */
        public function blob(){
            $this->clean();
            array_push($this->options, 'blob');
            $this->PHP_type = "string";
            return $this;
        }

        /**
         * This column is null
         * @return \Framework\Database\Config\Column
         */
        public function nullable(){            
            if(array_key_exists('not null', $this->options))
                unset($array['not null']);
            array_push($this->options, 'null');
            return $this;
        }

        /**
         * This column is auto incremented
         * @return \Framework\Database\Config\Column
         */
        public function autoIncrement(){
            $this->clean();
            array_push($this->options, 'INTEGER');
            $this->PHP_autoIncrement = true;
            return $this;
        }

        /**
         * This column is primary
         * @return \Framework\Database\Config\Column
         */
        public function primary(){            
            array_push($this->options, 'PRIMARY KEY');
            $this->PHP_primary = true;
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
            if(array_key_exists('null', $this->options))
                unset($array['null']);
            array_push($this->options, 'not null');
            return $this;
        }

        /**
         * Check if this columns is primary key
         * @return boolean
         */
        public function isPrimary(){
            return array_key_exists('PRIMARY KEY', $this->options);
        }
    }
}