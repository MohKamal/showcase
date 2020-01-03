<?php

namespace Facade\Controllers{

    use \Facade\AutoLoad;
    use \Facade\Utils\Validation\Validator;
    use \Facade\Utils\HTTP\Links\URL;
    use \Facade\Models\User;
    
    class UserController{
        
        /**
         * store new user
         */
        static function store($request){
            if(Validator::Validate($request->getBody(), ['name', 'email', 'password'])){
                $user = new User($request->getBody()['name'], $request->getBody()['email'], $request->getBody()['password']);
                $user->save();
                return URL::Redirect('login'); // if no user found redirect to home
            }
            return URL::Redirect('register');
        }

    }
}