<?php
namespace Showcase\Framework\HTTP\Controllers{
    
    use \Showcase\AutoLoad;
    use \Showcase\Framework\Validation\Validator;
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Views\View;
    
    /**
     * 
     * The Base controller with the basic includes
     * 
     */
    class BaseController{
        
        /**
         * 
         * return a view by name
         * 
         * @param string view name
         */
        function view($view, array $vars=array()){
            return View::show($view, $vars);
        }
    }
}