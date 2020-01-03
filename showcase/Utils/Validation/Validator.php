<?php
namespace Facade\Utils\Validation{
    class Validator
    {

        /**
         * Verify an object vars to get no null values
         */
        static function Validate($object, array $fields){
            foreach($fields as $field){
                if($object[$field] == null)
                    return false;
            }

            return true;
        }
    }
}