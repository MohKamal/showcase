<?php

namespace Showcase\Framework\Views {
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Utils\Utilities;
    
    /**
     * Loading and showing views files
     * Also Replacing the functions in the views with their values such as Assets url
     */
    class View
    {
        /**
         * Show the view by giving the sub folder and the name
         * @param $view view name example : Auth/Login Or Auth/Login.view.php
         */
        static function show($view){
            //Checking the view name and its etension to call the correct file from the view folder
            $file_parts = pathinfo($view);
            $file = "";
            if(empty($file_parts['extension']))
                $file = dirname(__FILE__) . '\..\..\Views\\' . $view . '.view.php';
            else{
                if(Utilities::endsWith($view, '.view.php'))
                    $file = dirname(__FILE__) . '\..\..\Views\\' . $view;
                else
                    $file = dirname(__FILE__) . '\..\..\Views\\' . substr_replace($view , 'view.php', strrpos($view , '.') +1);
            }
            //Checking if the file exist
            if (file_exists($file)) { 
                //requiering the views all the componements 
                require_once 'BaseView.php';
                //Checking the view function to replace them with the correct values
                $matches = array();
                $page = file_get_contents($file);
                preg_match_all('/@{{(.*)}}/', $page, $matches);
                foreach ($matches as $array) {
                    foreach ($array as $function) {
                        $result = View::parsingFunctions($function);
                        $page = str_replace($function, $result, $page);
                    }
                }
                //Displaying the page
                echo $page;
                return http_response_code(200);       
            }
            //If no file found => 404 :(
            return http_response_code(404);
        }

        /**
         * Returning a value based on the name of the function such as Assets Url or the app Base Url
         */
        static function parsingFunctions($function){
            switch(strtolower($function)){
                case '@{{assets}}':
                    return URL::assets();
                break;
                case '@{{base}}':
                    return URL::BASE();
                break;
            }

            return '';
        }


    }
}