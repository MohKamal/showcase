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
            $page = self::printView($view);

            //If no file found => 404 :(
            if(empty($page))
                return http_response_code(404);

            echo $page;
            //return http_response_code(200);       
        }

        /**
         * Returning a value based on the name of the function such as Assets Url or the app Base Url
         */
        static function parsingFunctions($function){
            switch(strtolower($function)){
                case 'styles':
                    return URL::styles();
                break;
                case 'scripts':
                    return URL::scripts();
                break;
                case 'assets':
                    return URL::assets();
                break;
                case 'base':
                    return URL::BASE();
                break;
                case 'bootsrap-style':
                    return URL::bootstrapStyle();
                break;
                case 'bootsrap-script':
                    return URL::bootstrapScript();
                break;
                case 'jquery':
                    return URL::Jquery();
                break;
            }

            return '';
        }

        /**
         * Show the view by giving the sub folder and the name
         * @param $view view name example : Auth/Login Or Auth/Login.view.php
         */
        static function printView($view){
            //Checking the view name and its etension to call the correct file from the view folder
            $file_parts = pathinfo($view);
            $file = "";
            if(empty($file_parts['extension']))
                $file = dirname(__FILE__) . '/../../Views/' . $view . '.view.php';
            else{
                if(Utilities::endsWith($view, '.view.php'))
                    $file = dirname(__FILE__) . '/../../Views/' . $view;
                else
                    $file = dirname(__FILE__) . '/../../Views/' . substr_replace($view , 'view.php', strrpos($view , '.') +1);
            }

            //Checking if the file exist
            if (file_exists($file)) { 
                //requiering the views all the componements 
                require_once 'BaseView.php';

                //Checking the view function to replace them with the correct values
                $matches = array();
                $page = file_get_contents($file);
                preg_match_all('/@{{(.*)}}/', $page, $matches);
                foreach ($matches[0] as $function) {
                    //Replace special characters
                    $_function = str_replace("@{{", '', $function);
                    $_function = str_replace("}}", '', $_function);
                    //Get the function results
                    $result = self::parsingFunctions($_function);
                    $page = str_replace($function, $result, $page);
                }

                //Chech for include function
                $matches = array();
                preg_match_all('#\@include(.*?)\)#', $page, $matches);
                foreach ($matches[0] as $subView) {
                    //Replace special characters
                    $_subView = str_replace('@include("', '', $subView);
                    $_subView = str_replace('")', '', $_subView);
                    //Get the function results
                    $result = self::printView($_subView);
                    $page = str_replace($subView, $result, $page);
                }


                //Chech for include function
                $matches = array();
                preg_match_all('#\@extend(.*?)\)#', $page, $matches);
                foreach ($matches[0] as $extendView) {
                    //Replace special characters
                    $_extendView = str_replace('@extend("', '', $extendView);
                    $_extendView = str_replace('")', '', $_extendView);
                    //Get the function results
                    $parent = self::printView($_extendView);
                    $_matches = array();
                    preg_match_all('#\@render(.*?)\)#', $parent, $_matches);
                    if (count($_matches) > 0) {
                        $page = str_replace($extendView, '', $page);
                        $parent = str_replace('@render()', $page, $parent);
                        $page = $parent;
                    }
                }
                //Displaying the page
                return $page;
            }
            return '';
        }

    }
}