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
        protected $types = array('varchar(250)', 'int', 'tinyint', 'double', 'float', 'text', 'blob');

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
         * Column options
         * @var array
         */
        public $options = array();

        public function __constructor(){
            $this->notnull();
        }

        /**
         * This column is string
         */
        public function string(){
            $this->clean();
            array_push($this->options, 'varchar(250)');
            return $this;
        }

        /**
         * This column is int
         */
        public function int(){
            $this->clean();
            array_push($this->options, 'int');
            return $this;
        }

        /**
         * This column is double
         */
        public function double(){
            $this->clean();
            array_push($this->options, 'double');
            return $this;
        }

        /**
         * This column is float
         */
        public function float(){
            $this->clean();
            array_push($this->options, 'float');
            return $this;
        }

        /**
         * This column is bool
         */
        public function bool(){
            $this->clean();
            array_push($this->options, 'tinyint');
            return $this;
        }

        /**
         * This column is text
         */
        public function text(){
            $this->clean();
            array_push($this->options, 'text');
            return $this;
        }

        /**
         * This column is blob
         */
        public function blob(){
            $this->clean();
            array_push($this->options, 'blob');
            return $this;
        }

        /**
         * This column is null
         */
        public function nullable(){            
            if(array_key_exists('not null', $this->options))
                unset($array['not null']);
            array_push($this->options, 'null');
            return $this;
        }

        /**
         * Set the column name
         * @var string
         */
        public function name($name){
            if(!empty($name))
                $this->name = $name;
            return $this;
        }

        /**
         * This column is null
         */
        public function notnull(){
            if(array_key_exists('null', $this->options))
                unset($array['null']);
            array_push($this->options, 'not null');
            return $this;
        }
    }
}