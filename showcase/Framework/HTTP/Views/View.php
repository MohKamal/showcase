<?php
namespace Showcase\Framework\Views{
    use \Showcase\AutoLoad;
    
    class View
    {
        /**
         * Generate url from page name
         * @param $page Page name as index.php
         */
        static function redirect($page){
            ob_start(); //this should be first line of your page
            header("Location:". AutoLoad::env('VIEW') . $page);
            ob_end_flush(); //this should be last line of your page
        }

    }

}