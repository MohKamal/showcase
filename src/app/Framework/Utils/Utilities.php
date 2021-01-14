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

    }
}