<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;

    class HomeController extends BaseController{

        /**
         * Return the welcome view
         */
        static function Index(){
            return self::response()->view('App/welcome', array(
                'url' => 'https://google.com',
                'title' => 'google',
                'locations' => array(1, 5, 6, 7),
            ));
        }
    }
}