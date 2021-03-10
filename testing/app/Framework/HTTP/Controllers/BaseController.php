<?php
namespace  Showcase\Framework\HTTP\Controllers{
    
    use \Showcase\Framework\HTTP\Controllers\BaseControllerInterface;
    use \Showcase\Framework\Views\View;
    use \Showcase\Framework\HTTP\Routing\Response;
    use \Showcase\Framework\IO\Storage\Storage;
    
    /**
     * 
     * The Base controller with the basic includes
     * 
     */
    class BaseController implements IBaseController{
        
        /**
         * 
         * return a view by name
         * 
         * @param string view name
         */
        static function view($view, array $vars=array()){
            return View::show($view, $vars);
        }

        /**
         * Get a reponse object for an easy reponse
         * 
         * @return \Showcase\Framework\HTTP\Routing\Response
         */
        static function response(){
            $reponse = new Response();
            return $reponse;
        }

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        static function storage($foldername){
            return Storage::folder($foldername);
        }

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        static function storageResources($foldername){
            return Storage::resources($foldername);
        }

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        static function storageGlobal(){
            return Storage::global();
        }
    }
}