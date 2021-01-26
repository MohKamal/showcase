<?php
namespace  Showcase\Framework\Validation{

    use \Showcase\Framework\Utils\Utilities;
    /**
     * Request Validator
     * Valid a request if it got some fields
     */
    class Validator
    {
        /**
         * Verify an object vars to check if the specifyied exist
         * @param \Showcase\Framework\HTTP\Routing\Request object
         * @param array fiels
         */
        public static function validate($object, array $fields){
            foreach($fields as $field){
                if (!array_key_exists($field, $object))
                    return false;
                if(!self::required($object[$field]))
                    return false;
            }

            return true;
        }

        /**
         * Verify an object vars to get no null values with more specifications
         * like data type, min and max, validation formats
         * @param \Showcase\Framework\HTTP\Routing\Request object
         * @param array fiels
         */
        public static function validation($object, array $fields){
            $errors = array();
            foreach($fields as $key => $value){
                if (array_key_exists($key, $object)) {
                    $_specifications = explode("|", $value);
                    $specifications = array();
                    foreach($_specifications as $s)
                        $specifications[] = str_replace(' ', '', $s);
                    foreach($specifications as $spec){
                        if(Utilities::startsWith($spec, 'max') || Utilities::startsWith($spec,'min')){
                            $data = explode(":", $spec);
                            $valid = self::fieldSpecification($data[0], $object[$key], $data[1]);
                            if(!$valid) $errors[] = "$data[0] lenght of $key is $data[1]";
                        }else{
                            $valid = self::fieldSpecification($spec, $object[$key]);
                            if(!$valid){
                                if(strtolower($spec) === 'required')
                                    $errors[] = "$key is required";
                                else
                                    $errors[] = "$key need to be $spec";
                            }
                        }
                    }
                }else{
                    $errors[] = "$key is not defined in the set of variables";
                }

            }

            return $errors;
        }

        /**
         * Check the specifications and return the correct function
         * 
         * @param string $spec specification
         * @param string $value value from the request
         * @param numeric $lenght optional value lenght for max and mix function
         * 
         * @return boolean
         */
        protected static function fieldSpecification($spec, $value, $lenght=0){
            switch(strtolower($spec)){
                case 'required':
                    return self::required($value);
                case 'string':
                    return self::string($value);
                case 'numeric':
                    return self::numeric($value);
                case 'max':
                    return self::max($value, $lenght);
                case 'min':
                    return self::min($value, $lenght);
                case 'email':
                    return self::email($value);
                case 'phone':
                    return self::phone($value);
            }
        }

        /**
         * required specification
         * @param string $value
         * @return boolean
         */
        protected static function required($value){
            if(is_null($value) || empty($value))
                return false;
            return true;
        }

        /**
         * string specification
         * @param string $value
         * @return boolean
         */
        protected static function string($value){
            return is_string($value);
        }

        /**
         * numeric specification
         * @param string $value
         * @return boolean
         */
        protected static function numeric($value){
            return is_numeric($value);
        }

        /**
         * required specification
         * @param string $value
         * @param numeric $lenght
         * @return boolean
         */
        protected static function max($value, $lenght){
            if(is_numeric($value)){
                if($value > $lenght)
                    return false;
            }else{
                if (strlen($value) > $lenght) {
                    return false;
                }
            }
            return true;
        }

        /**
         * required specification
         * @param string $value
         * @param numeric $lenght
         * @return boolean
         */
        protected static function min($value, $lenght){
            if(is_numeric($value)){
                if($value < $lenght)
                    return false;
            }else{
                if (strlen($value) < $lenght) {
                    return false;
                }
            }
            return true;
        }

        /**
         * required specification
         * @param string $value
         * @return boolean
         */
        protected static function email($value){
            if (!filter_var($value, FILTER_VALIDATE_EMAIL))
                return false;
            return true;
        }

        /**
         * required specification
         * @param string $value
         * @return boolean
         */
        protected static function phone($value){
            if(!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $value))
                return false;
            return true;
        }
    }
}