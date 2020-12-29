<?php

namespace Showcase\Framework\Views {
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Utils\Utilities;
    use \Showcase\Framework\IO\Debug\Log;
    
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
        static function show($view, array $vars=array()){
            $page = self::printView($view);
            //check for php code
            $page = self::executeCode($page, self::varsToString($vars));
            //check for if
            $page = self::checkForConditions($page, self::varsToString($vars));
            //check for foreach and for
            $page = self::checkForLoops($page, self::varsToString($vars));
            //check for variables
            if(!empty($vars))
                $page = self::checkVariables($page, $vars);
            //If no file found => 404 :(
            if(empty($page))
                return http_response_code(404);

            echo $page;
            //return http_response_code(200);
        }

        /**
         * Returning a value based on the name of the function such as Assets Url or the app Base Url
         * 
         * @param string $function name
         * 
         * @return string correct path
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
         * 
         * @return string view code
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

        /**
         * This function search for @php code to execute
         * inside a view
         * @param String $page view code
         * 
         * @return String view code with php executed
         */
        static function executeCode($page, $vars){
            //Chech for php function
            $matches = array();
            preg_match_all('#\@php(.*?)\@endphp#s', $page, $matches);
            $result_to_display = '';
            foreach ($matches[0] as $subView) {
                //Replace special characters
                $_subView = str_replace('@php', '', $subView);
                $_subView = str_replace('@endphp', '', $_subView);
                $diplayFunction = '$names =  get_defined_vars(); global $result_to_display; extract($names, EXTR_PREFIX_SAME, "wddx"); if (!function_exists("display")){ function display($string){global $result_to_display; $result_to_display .= $string; return $result_to_display;}}' . "\n";
                $program = $vars . $diplayFunction . $_subView;
                //Get the function results
                $result = eval($program);
                if(!empty($result_to_display))
                    $result .= $result_to_display;
                $page = str_replace($subView, $result, $page);
            }
            return $page;
        }

        /**
         * This function search for variables sent from contollers
         * to be printed inside a view, like url, title etc...
         * @param String $page view code
         * @param array $vars and variables, names and values
         * 
         * @return String view code with variables checked
         */
        static function checkVariables($page, array $vars){
            //Chech for include function
            $matches = array();
            foreach ($vars as $key => $value) {
                //Replace special characters
                if(!is_array($value))
                    $page = str_replace("$$key", $value, $page);
            }
            return $page;
        }

        /**
         * check for loop like foreach and for
         * @param string $page view code
         * 
         * @return string view code
         */
        static function checkForLoops($page, $vars){
            //Chech for foreach or for loop
            //Log::print($page);
            $matches = array();
            preg_match_all('#\@foreach(.*?)\@endforeach#s', $page, $matches);
            $result_to_display = '';
            foreach ($matches[0] as $subView) {
                //Replace special characters
                $_subView = str_replace('@endforeach', '', $subView);
                $_subView = str_replace('@foreach', 'foreach', $_subView);
                $diplayFunction = '$names =  get_defined_vars(); global $result_to_display; extract($names, EXTR_PREFIX_SAME, "wddx"); if (!function_exists("display")){function display($string){global $result_to_display; $result_to_display .= $string; return $result_to_display;}}' . "\n";
                $program = $vars . $diplayFunction . $_subView;
                //Get the function results
                $result = eval($program);
                if(!empty($result_to_display))
                    $result .= $result_to_display;
                //Get the function results
                $page = str_replace($subView, $result, $page);
            }

            $matches = array();
            preg_match_all('#\@for(.*?)\@endfor#s', $page, $matches);
            $result_to_display = '';
            foreach ($matches[0] as $subView) {
                //Replace special characters
                $_subView = str_replace('@endfor', '', $subView);
                $_subView = str_replace('@for', 'for', $_subView);
                $diplayFunction = '$names =  get_defined_vars(); global $result_to_display; extract($names, EXTR_PREFIX_SAME, "wddx"); if (!function_exists("display")){function display($string){global $result_to_display; $result_to_display .= $string; return $result_to_display;}}' . "\n";
                $program = $vars . $diplayFunction . $_subView;
                //Get the function results
                $result = eval($program);
                if(!empty($result_to_display))
                    $result .= $result_to_display;
                $page = str_replace($subView, $result, $page);
            }
            //Log::print($page);
            return $page;
        }
        
        /**
         * check for loop like foreach and for
         * @param string $page view code
         * 
         * @return string view code
         */
        static function checkForConditions($page, $vars){
            //Chech for foreach or for loop
            $matches = array();
            preg_match_all('#\@if(.*?)\@endif#s', $page, $matches);
            $result_to_display = '';
            foreach ($matches[0] as $subView) {
                //Replace special characters
                $_subView = str_replace('@endif', '', $subView);
                $_subView = str_replace('@elseif', 'else if', $_subView);
                $_subView = str_replace('@if', 'if', $_subView);
                $_subView = str_replace('@else', 'else', $_subView);
                $diplayFunction = '$names =  get_defined_vars(); global $result_to_display; extract($names, EXTR_PREFIX_SAME, "wddx"); if (!function_exists("display")){function display($string){global $result_to_display; $result_to_display .= $string; return $result_to_display;}}' . "\n";
                $program = $vars . $diplayFunction . $_subView;
                //Get the function results
                $result = eval($program);
                if(!empty($result_to_display))
                    $result .= $result_to_display;
                $page = str_replace($subView, $result, $page);
            }
            return $page;
        }

        /**
         * Convert the variables sent from controller to view to string to be included
         * in eval function
         */
        static function varsToString(array $vars){
            if(empty($vars))
                return '';

            $string = '';
            foreach($vars as $key => $value){
                if(is_array($value))
                    $string .= "$$key=array(" . self::arrayToStringVar($value) . ");\n";
                else
                    $string .= "$$key=" . "'$value';\n";
            }

            return $string;
        }

        /***
         * If the user send an array inside the variables sent to the view
         * this function convert it to string
         */
        static function arrayToStringVar(array $vars){
            if(empty($vars))
                return '';

            if(!is_array($vars))
                return '';
            $string = '';
            foreach ($vars as $key => $value) {
                if(is_numeric($value))
                    $string .= "$value,";
                else
                    $string .= "'$value',";
            }
            
            return substr($string, 0, -1);
        }
    }
}