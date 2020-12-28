<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Validation\Validator;
    use \Showcase\Models\User;
    use \Showcase\Framework\HTTP\Gards\Auth;

    class LoginController extends BaseController{

        /**
         * Return the welcome view
         */
        static function login($request){
            if (Validator::Validate($request->getBody(), ['email', 'password'])) {
                if(!Auth::login($request->getBody()['email'], $request->getBody()['password']))
                    return self::response()->unauthorized();
            }
            return self::response()->view('App/welcome');
        }
    }
}