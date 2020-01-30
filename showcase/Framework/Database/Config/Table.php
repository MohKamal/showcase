<?php
namespace Showcase\Framework\Database\Config {
    use \Showcase\AutoLoad;
    use \Showcase\Framewok\IO\Debug\Log;
    
    class Table{

        /**
         * @var string table name
         */
        private $name = "tabel_name";

        /**
         * Table columns
         * @var array
         */
        protected $columns = array();

        public function column($name, array $params){
            if(empty($name))
                return false;
            
            if(empty($params))
                return false;
            array_push($this->columns, $params);
        }
    }
}