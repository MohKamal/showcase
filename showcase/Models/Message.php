<?php
namespace Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Exception;
    
    class Message extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'message';
            BaseModel::__construct();
        }

    }

}