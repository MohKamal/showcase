<?php
namespace  Showcase\Framework\HTTP\Controllers{
    
    /**
     * 
     * The Base controller with the basic includes
     * 
     */
    interface IBaseController{
        
        /**
         * 
         * return a view by name
         * 
         * @param string view name
         */
        static function view($view, array $vars=array());

        /**
         * Get a reponse object for an easy reponse
         * 
         * @return \Showcase\Framework\HTTP\Routing\Response
         */
        static function response();

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        static function storage($foldername);

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        static function storageResources($foldername);

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        static function storageGlobal();
    }
}