<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Database\DB;
    use \Showcase\Framework\IO\Debug\Log;

    class HomeController extends BaseController{

        /**
         * Return the welcome view
         */
        static function Index(){
            $users = DB::model('User')->select()->where('email', '%@gmail%', 'LIKE')->where('firstname', 'a')->get();
            //Log::print($user->email);
            //$users = DB::table('users')->select()->get();
            foreach($users as $user)
                Log::print($user->email . " | " . $user->username);
            return self::response()->view('App/welcome');
        }
    }
}