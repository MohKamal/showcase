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

            if (Validator::validate($request->getBody(), ['email', 'password'])) {
                if(!Auth::login($request->getBody()['email'], $request->getBody()['password']))
                    return self::response()->unauthorized();
            }
            return self::response()->redirect('/');
        }

        /**
         * Logout user
         */
        static function logout(){
            if(Auth::logout())
                return self::response()->redirect('/');
            
            return self::response()->unauthorized();
        }
    }
}