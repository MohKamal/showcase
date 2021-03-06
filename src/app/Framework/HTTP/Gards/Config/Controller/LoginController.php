<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace  Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Validation\Validator;
    use \Showcase\Models\User;
    use \Showcase\Framework\HTTP\Gards\Auth;

    class LoginController extends BaseController{

        /**
         * Login a user
         */
        static function login($request){
            if(Auth::check())
                return self::response()->redirect('/');

            if (Validator::validate($request->get(), ['email', 'password'])) {
                $remember = $request->get()['remember'] == 'on' ? true : false;
                if(!Auth::login($request->get()['email'], $request->get()['password'], $remember))
                    return self::response()->unauthorized();
            }
            return self::response()->redirect('/');
        }

        /**
         * Logout user
         */
        static function logout(){
            Auth::logout();
            return self::response()->redirect('/');
        }
    }
}