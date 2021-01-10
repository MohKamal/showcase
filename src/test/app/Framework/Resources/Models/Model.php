<?php
namespace  Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Exception;
    
    class NameModel extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'NameMigration';
            BaseModel::__construct();
        }

    }

}