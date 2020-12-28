<?php
namespace Showcase\Framework\Validation{
    /**
     * Request Validator
     * Valid a request if it got some fields
     */
    class Validator
    {
        /**
         * Verify an object vars to get no null values
         * @param \Showcase\Framework\HTTP\Routing\Request object
         * @param array fiels
         */
        static function Validate($object, array $fields){
            foreach($fields as $field){
                if (array_key_exists($field, $object)) {
                    if ($object[$field] == null) {
                        return false;
                    }
                }
                else
                    return false;

            }

            return true;
        }
    }
}