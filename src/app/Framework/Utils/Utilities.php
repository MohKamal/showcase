<?php
namespace  Showcase\Framework\Utils{
    /**
     * Regroup the functions that can be Used by all files
     */
    class Utilities{

        /**
         * Check if a string start with a string
         */
        static function startsWith($haystack, $needle)
        {
            $length = strlen($needle);
            return (substr($haystack, 0, $length) === $needle);
        }

        /**
         * Check if a string ends with a string
         */
        static function endsWith($haystack, $needle)
        {
            $length = strlen($needle);
            if ($length == 0) {
                return true;
            }

            return (substr($haystack, -$length) === $needle);
        }

        /**
         * Get a string between two strings
         * @param string $string original string
         * @param string $start first string
         * @param string $end last string
         * 
         * @return string
         */
        static function get_string_between($string, $start, $end){
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }

    }
}