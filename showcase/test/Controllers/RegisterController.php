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

    class RegisterController extends BaseController{

        /**
         * Return the welcome view
         */
        static function store($request){
            if (Validator::Validate($request->getBody(), ['email', 'password', 'username'])) {
                $user = new User();
                $user->bcrypt($request->getBody()['password']);
                $user->username = $request->getBody()['username'];
                $user->email = $request->getBody()['email'];
                $user->save();

                //Log the user
                Auth::loginWithEmail($user->email);
                return self::response()->view('App/welcome');
            }
            return self::response()->redirect('errors/500');
        }
    }
}