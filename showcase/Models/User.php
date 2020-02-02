<?php
namespace Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Showcase\Framework\IO\Debug\Log;
    use \Exception;
    
    class User extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'users';
            parent::__construct();
        }

    }

}