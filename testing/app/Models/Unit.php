<?php
namespace Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Exception;
    
    class Unit extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'Unit';
            BaseModel::__construct();
            $this->variables = ['category'];
        }
        public $category = "Test";
    }

}