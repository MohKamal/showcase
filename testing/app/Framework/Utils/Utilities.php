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
        static function getStringBetween($string, $start, $end){
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }

        /**
         * make a slug from a string
         * @param string $text to slugify
         * 
         * @return string
         */
        public static function slugify($text)
        {
            // replace non letter or digits by -
            $text = preg_replace('~[^\pL\d]+~u', '-', $text);
            // transliterate
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
            // remove unwanted characters
            $text = preg_replace('~[^-\w]+~', '', $text);
            // trim
            $text = trim($text, '-');
            // remove duplicate -
            $text = preg_replace('~-+~', '-', $text);
            // lowercase
            $text = strtolower($text);
            if (empty($text)) {
                return 'n-a';
            }

            return $text;
        }

    }
}