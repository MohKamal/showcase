<?php
namespace  Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Exception;
    
    class User extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'User';
            BaseModel::__construct();
        }

    }

}