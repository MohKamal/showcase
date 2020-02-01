<?php
namespace Showcase\Framework\Database\Config {
    use \Showcase\AutoLoad;
    use \Showcase\Framewok\IO\Debug\Log;
    
    class Table{

        /**
         * @var string table name
         */
        public $name = "tabel_name";

        /**
         * Table columns
         * @var array
         */
        public $columns = array();

        public function column($name, array $params){
            if(empty($name))
                return false;
            
            if(empty($params))
                return false;
            array_push($this->columns, ["name" => $name, "params" => $params]);
        }
    }
}