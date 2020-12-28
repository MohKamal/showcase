<?php
namespace Showcase\Framework\HTTP\Controllers{
    
    use \Showcase\AutoLoad;
    use \Showcase\Framework\Views\View;
    use \Showcase\Framework\HTTP\Routing\Response;
    
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

        /**
         * Get a reponse object for an easy reponse
         */
        function response(){
            $reponse = new Response();
            return $reponse;
        }
    }
}