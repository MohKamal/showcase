<?php

namespace Showcase\Framework\Views {
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Utils\Utilities;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Session\SessionAlert;
    use \Showcase\Framework\IO\Storage\Storage;
    
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
            //sections
            $page = self::sections($page);
            //check for php code
            $page = self::executeCode($page);
            $page = self::checkVariables($page);
            //check for foreach and for
            $page = self::checkForLoops($page);
            //check for if
            $page = self::checkForConditions($page);
            //Check for native display in html
            $page = self::checkForDisplay($page);
            //check for sessionAlert
            $page = self::checkForSessionAlert($page);
            //check for csrf
            $page = self::checkForCSRF($page);
            //If no file found => 404 :(
            if(empty($page))
                return http_response_code(404);

            //add base files
            $file_include = dirname(__FILE__) . '/BaseView.php';
            $includes = file_get_contents($file_include);

            //add models
            $include_models = "\n";
            $dir_models = dirname(__FILE__) . '/../../Models';
            if (file_exists($dir_models)) {
                $models = scandir($dir_models, 1);
                foreach($models as $model) {
                    $file_parts = pathinfo($model);
                    if($file_parts['extension'] == "php") {
                        $include_models .= "use \Showcase\Models\\" . basename($model,".php") . ";\n";
                    }
                }
            }
            //create file content
            $page = $includes . "\n" . $include_models . "\n" . self::varsToString($vars) . "\n?>\n" . $page;
            Storage::folder('temp')->put("_temp_view.php", $page);
            ob_start();
            require_once Storage::folder('temp')->path('_temp_view.php');
            $contents = ob_get_contents();
            ob_end_clean();
            echo $contents;
            Storage::folder('temp')->remove('_temp_view.php');
            SessionAlert::clear();
        }

        
        /**
         * Get the view HTML as String to be used in other things like view to pdf
         * @param $view view name example : Auth/Login Or Auth/Login.view.php
         */
        static function get($view, array $vars=array()){
            $page = self::printView($view);
            //check for php code
            $page = self::executeCode($page);
            $page = self::checkVariables($page);
            //check for foreach and for
            $page = self::checkForLoops($page);
            //check for if
            $page = self::checkForConditions($page);
            //Check for native display in html
            $page = self::checkForDisplay($page);
            //check for sessionAlert
            $page = self::checkForSessionAlert($page);
            //check for csrf
            $page = self::checkForCSRF($page);
            //If no file found => 404 :(
            if(empty($page))
                return http_response_code(404);

            //add base files
            $file_include = dirname(__FILE__) . '/BaseView.php';
            $includes = file_get_contents($file_include);

            //add models
            $include_models = "\n";
            $dir_models = dirname(__FILE__) . '/../../Models';
            if (file_exists($dir_models)) {
                $models = scandir($dir_models, 1);
                foreach($models as $model){
                    $file_parts = pathinfo($model);
                    if($file_parts['extension'] == "php"){
                        $include_models .= "use \Showcase\Models\\" . basename($model,".php") . ";\n";
                    }
                }
            }
            //create file content
            $page = $includes . "\n" . $include_models . "\n" . self::varsToString($vars) . "\n?>\n" . $page;
            file_put_contents("_temp.php", $page);
            ob_start();
            require_once '_temp.php';
            $contents = ob_get_contents();
            ob_end_clean();
            unlink("_temp.php");
            SessionAlert::clear();
            return $contents;
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
                    return URL::base();
                break;
                case 'bootsrap-style':
                    return URL::bootstrapStyle();
                break;
                case 'bootsrap-script':
                    return URL::bootstrapScript();
                break;
                case 'jquery':
                    return URL::jquery();
                break;
                case 'images':
                    return URL::images();
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
                $file = Storage::views()->path($view . '.view.php');
            else{
                if(Utilities::endsWith($view, '.view.php'))
                     $file = Storage::views()->path($view);
                else
                     $file = Storage::views()->path(substr_replace($view , 'view.php', strrpos($view , '.') +1));
            }

            //Checking if the file exist
            if (file_exists($file)) { 
                //requiering the views all the componements 

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
         * This function search for @section to display in the correct part of the html
         * @param String $page view code
         * 
         * @return String view code with no @section inside it
         */
        static function sections($page){
            //Chech for section function
            $matches = array();
            preg_match_all('#\@section(.*?)\@endsection#s', $page, $matches);
            $sections_code = array();
            foreach ($matches[0] as $subView) {
                //Replace special characters
                $section_name = Utilities::getStringBetween($subView, "@section(", ")");
                $section_name = str_replace('"', '', $section_name);

                $_subView = str_replace('@section("' . $section_name . '")', '', $subView);
                $_subView = str_replace('@endsection', '', $_subView);
                if(!key_exists($section_name, $sections_code))
                    $sections_code[strtolower($section_name)] = "";
                    
                $sections_code[strtolower($section_name)] .= $_subView;
                $page = str_replace($subView, "", $page);
            }

                $matches = array();
                preg_match_all('#\@renderSection(.*?)\)#', $page, $matches);
                foreach ($matches[0] as $subView) {
                    //Replace special characters
                    $section_name = str_replace('@renderSection("', '', $subView);
                    $section_name = str_replace('")', '', $section_name);
                    $section_name = strtolower($section_name);
                    if (!empty($sections_code) && key_exists($section_name, $sections_code)) {
                        $page = str_replace($subView, $sections_code[$section_name], $page);
                    }else{ //if no code was there remove renderSection
                        $page = str_replace($subView, "", $page);
                    }
                }
            return $page;
        }

        /**
         * This function search for @php code to execute
         * inside a view
         * @param String $page view code
         * 
         * @return String view code with php executed
         */
        static function executeCode($page){
            //Chech for php function
            $matches = array();
            preg_match_all('#\@php(.*?)\@endphp#s', $page, $matches);
            foreach ($matches[0] as $subView) {
                //Replace special characters
                $_subView = str_replace('@php', '<?php ', $subView);
                $_subView = str_replace('@endphp', ' ?>', $_subView);
                
                $page = str_replace($subView, $_subView, $page);
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
        static function checkVariables($page){
            //Chech for vars function
            $matches = array();
            preg_match_all('#\{{(.*?)\}}#', $page, $matches);
            foreach ($matches[0] as $subView) {
                //Replace special characters
                $_subView = str_replace('{{', '<?php echo ', $subView);
                $_subView = str_replace('}}', ' ?>', $_subView);
                //Get the function results
                $page = str_replace($subView, $_subView, $page);
            }
            return $page;
        }

        /**
         * check for loop like foreach and for
         * @param string $page view code
         * 
         * @return string view code
         */
        static function checkForLoops($page){
            //Chech for foreach or for loop
            $matches = array();
            preg_match_all('#\@foreach(.*?)\@endforeach#s', $page, $matches);
            $found = false;
            if(!empty($matches) && !empty($matches[0]))
                $found = true;
            while ($found) {
                foreach ($matches[0] as $subView) {
                    //Replace special characters
                    $search = "#@foreach.*?\n#";
                    preg_match($search, $subView, $match);
                    if (!empty($match)) {
                        $foreach = str_replace('@foreach', '<?php foreach', $match[0]);
                        $foreach = str_replace("\n", " { ?>\n", $foreach);
                        $_subView = str_replace($match[0], $foreach, $subView);
                    }
                    $_subView = str_replace('@endforeach', '<?php } ?>', $_subView);
                    $page = str_replace($subView, $_subView, $page);
                }
                
                $matches = array();
                preg_match_all('#\@foreach(.*?)\@endforeach#s', $page, $matches);
                $found = false;
                if(!empty($matches) && !empty($matches[0]))
                    $found = true;
            }


            $matches = array();
            preg_match_all('#\@for(.*?)\@endfor#s', $page, $matches);
            $found = false;
            if(!empty($matches) && !empty($matches[0]))
                $found = true;
            while ($found) {
                foreach ($matches[0] as $subView) {
                    //Replace special characters
                    $search = "#@for.*?\n#";
                    preg_match($search, $subView, $_match);
                    if (!empty($_match)) {
                        $for = str_replace('@for', '<?php for', $_match[0]);
                        $for = str_replace("\n", " { ?>\n", $for);
                        $_subView = str_replace($_match[0], $for, $subView);
                    }
                    $_subView = str_replace('@endfor', '<?php } ?>', $_subView);
                    $page = str_replace($subView, $_subView, $page);
                }

                $matches = array();
                preg_match_all('#\@for(.*?)\@endfor#s', $page, $matches);
                $found = false;
                if(!empty($matches) && !empty($matches[0]))
                    $found = true;
            }
            return $page;
        }
        
        /**
         * check for if statement
         * @param string $page view code
         * 
         * @return string view code
         */
        static function checkForConditions($page){
            //Chech for foreach or for loop
            $matches = array();
            preg_match_all('#\@if(.*?)\@endif#s', $page, $matches);
            foreach ($matches[0] as $subView) {
                //Replace special characters
                //end if
                $_subView = str_replace('@endif', '<?php }?>', $subView);

                //if
                $search = "#@if.*?\n#";
                preg_match($search, $_subView, $match);
                if (!empty($match)) {
                    $_if = str_replace('@if', '<?php if', $match[0]);
                    $_if = str_replace("\n", " { ?>\n", $_if);
                    $_subView = str_replace($match[0], $_if, $_subView);
                }
                //else if
                $_search = "#@elseif.*?\n#";
                preg_match($_search, $_subView, $_match);
                if (!empty($_match)) {
                    $__if = str_replace('@elseif', '<?php }else if', $_match[0]);
                    $__if = str_replace("\n", " { ?>\n", $__if);
                    $_subView = str_replace($_match[0], $__if, $_subView);
                }
                //else
                $_subView = str_replace('@else', '<?php }else{ ?>', $_subView);
                $page = str_replace($subView, $_subView, $page);
            }
            return $page;
        }

        /**
         * check for display functions
         * @param string $page view code
         * 
         * @return string view code
         */
        static function checkForDisplay($page){
            //Chech for foreach or for loop
            $matches = array();
            preg_match_all('#\@display(.*?)\@enddisplay#s', $page, $matches);
            foreach ($matches[0] as $subView) {
                //Replace special characters
                $_subView = str_replace('@enddisplay', ' ?>', $subView);
                $_subView = str_replace('@display', '<?php echo ', $_subView);
                $page = str_replace($subView, $_subView, $page);
            }
            return $page;
        }

        /**
         * check for sessionAlert
         * @param string $page view code
         * 
         * @return string view code
         */
        static function checkForSessionAlert($page){
            //Chech for foreach or for loop
            $matches = array();
            preg_match_all('#\@sessionAlert#', $page, $matches);
            foreach ($matches[0] as $subView) {
                $page = str_replace($subView, '<?php echo SessionAlert::show(); ?>', $page);
            }
            return $page;
        }

        /**
         * check for csrf function
         * @param string $page view code
         * 
         * @return string view code
         */
        static function checkForCSRF($page){
            //Chech for csrf
            $matches = array();
            preg_match_all('#\@csrfInject#', $page, $matches);
            foreach ($matches[0] as $subView) {
                $page = str_replace($subView, '<?php $csrf->start(); ?>', $page);
            }

            $matches = array();
            preg_match_all('#\@csrf#', $page, $matches);
            foreach ($matches[0] as $subView) {
                $page = str_replace($subView, '<?php echo $csrf->csrfguard_get_inputs(); ?>', $page);
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
                elseif (is_object($value)) 
                    $string .= "$$key=array(" . self::arrayToStringVar($value) . ");\n";
                else
                    $string .= "$$key=" . "'" . str_replace("'", "\'", $value) . "';\n";
            }
            return $string;
        }

        /***
         * If the user send an array inside the variables sent to the view
         * this function convert it to string
         */
        static function arrayToStringVar($vars, $use_key=false){
            if(empty($vars))
                return '';

            if(!is_array($vars))
                return '';
            $string = '';
            foreach ($vars as $key => $value) {
                    if (is_numeric($value)) {
                        if($use_key)
                            $string .= "'$key' => $value,";
                        else
                            $string .= "$value,";
                    } elseif (is_string($value)) {
                        if ($use_key) {
                            if(!strpos($value, "'"))
                                $string .= "'$key' => '" . str_replace('"', '', $value) . "',";
                            else
                                $string .= "'$key'" . '=> "' . str_replace('"', '', $value) . '",';
                        }
                        else{
                            $value = str_replace("'", "\'", $value);
                            $string .= "'". str_replace('"', '', $value) ."',";
                        }
                    } elseif (is_array($value)) {
                        $string .= "[" . self::arrayToStringVar($value, true) . "],";
                    } elseif (is_object($value)) {
                        $string .= "[" . self::arrayToStringVar(json_decode(json_encode($value), true), true) . "],";
                    }
            }
            
            return substr($string, 0, -1);
        }
    }
}