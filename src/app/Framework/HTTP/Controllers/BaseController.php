<?php
namespace  Showcase\Framework\HTTP\Controllers{
    
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\Views\View;
    use \Showcase\Framework\HTTP\Routing\Response;
    use \Showcase\Framework\IO\Storage\Storage;
    
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
         * 
         * @return \Showcase\Framework\HTTP\Routing\Response
         */
        function response(){
            $reponse = new Response();
            return $reponse;
        }

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        function storage($foldername){
            return Storage::folder($foldername);
        }

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        function storageResources($foldername){
            return Storage::resources($foldername);
        }

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        function storageGlobal(){
            return Storage::global();
        }
    }
}