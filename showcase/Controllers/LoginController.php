<?php

namespace Showcase\Controllers{

    use \Showcase\AutoLoad;
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Models\User;
    use \Showcase\Framework\Session\SessionAlert;
    use \Showcase\Framework\Validation\Validator;
    
    class LoginController{

        /**
         * Try to login the user
         */
        public function login($email, $password)
        {
            $user = $this->_checkCredentials($email, $password);
            if ($user != null) {
                session_start(); 
                $_SESSION['user'] = serialize($user);
                return true;
            }
            SessionAlert::Create('Email/Mot de passe erroné', 'error');
            return false;
        }

        /**
         * Check if the email and password are correct
         */
        protected function _checkCredentials($email, $password)
        {
            $find = false;
            $user = User::getByEmail($email);
            if($user != null){
                if(password_verify($password, $user->password))
                    return $user;
            }
            return null;
        }

        /**
         * Destroy session for logout
         */
        public static function logout(){
            session_start();
            session_destroy();
            return URL::Redirect('login');
        }

        static function Auth($request){
            if(Validator::Validate($request->getBody(), ['email', 'password'])){
                $auth = new LoginController();
                if($auth->login($request->getBody()['email'], $request->getBody()['password']))
                    return URL::Redirect('user-space'); // Redirect to calcule page
            }
            return URL::Redirect('login'); // if no user found redirect to home
        }

    }
}