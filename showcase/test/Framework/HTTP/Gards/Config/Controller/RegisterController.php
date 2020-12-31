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
         * Store new user
         */
        static function store($request){
            if (Validator::validate($request->getBody(), ['email', 'password', 'username'])) {
                $user = new User();
                $user->bcrypt($request->getBody()['password']);
                $user->username = $request->getBody()['username'];
                $user->email = $request->getBody()['email'];
                $user->save();

                //Log the user
                Auth::loginWithEmail($user->email);
                return self::response()->redirect('/');
            }
            return self::response()->redirect('errors/500');
        }
    }
}