<?php

namespace Showcase\Controllers{

    use \Showcase\AutoLoad;
    use \Showcase\Framwork\Validation\Validator;
    use \Showcase\Framwork\HTTP\Links\URL;
    use \Showcase\Models\User;
    
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