<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace  Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\HTTP\Gards\Auth;
    use \Showcase\Framework\HTTP\Routing\Request;
    use \Showcase\Framework\Database\DB;
    
    class UserController extends BaseController{

        /**
         * Return the welcome view
         */
        static function index(){
            return self::response()->view('App/welcome');
        }
    }
}