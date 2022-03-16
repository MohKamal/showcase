<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace Showcase\Controllers{
    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Database\DB;
    use \Showcase\Models\Unit;
    use \Showcase\Models\User;

    class HomeController extends BaseController{

        /**
         * Return the welcome view
         */
        static function Index(){
            throw new \Exception('<h1 style="color: red;">Error</h1>');
            return self::response()->view('App/welcome', ['doc' => 'Hola']);
        }
    }
}