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

    class RegisterController extends BaseController{

        /**
         * Store new user
         */
        static function store($request){
            $errors = Validator::validation($request->get(), [
                'email' => 'required | email', 
                'password' => 'required | min:8', 
                'username' => 'required | min:3 | max:10 | string'
                ]);
            if (empty($errors)) {
                $user = new User();
                $user->bcrypt($request->get()['password']);
                $user->username = $request->get()['username'];
                $user->email = $request->get()['email'];
                $user->save();

                //Log the user
                Auth::loginWithEmail($user->email);
                return self::response()->redirect('/');
            }
            return self::response()->view('Auth/register', array('errors' => $errors));
        }
    }
}