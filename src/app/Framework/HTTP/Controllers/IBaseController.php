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
        function view($view, array $vars=array());

        /**
         * Get a reponse object for an easy reponse
         * 
         * @return \Showcase\Framework\HTTP\Routing\Response
         */
        function response();

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        function storage($foldername);

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        function storageResources($foldername);

        /**
         * Get a storage object for an easy reponse
         * 
         * @return \Showcase\Framework\Storage\Storage
         */
        function storageGlobal();
    }
}