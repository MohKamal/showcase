<?php
namespace Showcase\Framework\HTTP\Gards{
    
    use \Showcase\AutoLoad;
    use \Showcase\Models\User;
    use \Showcase\Framework\IO\Debug\Log;

    /**
     * 
     * The Base controller with the basic includes
     * 
     */
    class Auth{
        
        // current user email if connected
        static $user_email = null;
        static $user_name = null;

        /**
         * Login function, but before that please create a User Model with email and password column
         * @param String
         * @return Boolean
         */
        public static function login($email, $password){
            if (empty($email) || empty($password)) {
                Log::print("Auth: Trying to log with empty coordinates");
                return false;
            }

            $user = new User();
            $user->where([
                'email' => $email
            ]);

            if ($user == null) {
                Log::print("Auth: No user was found with email " . $email);
                return false;
            }
            
            if($user->validHash($password, $user->password)){
                $_SESSION['user_id'] = $user->id;
                $_SESSION['user_email'] = $user->email;
                $_SESSION['user_name'] = $user->email;
                return true;
            }
            Log::print("Auth: Wrong password for " . $email);
            return false;
        }

        /**
         * Check if the user is connect
         * @return Boolean
         */
        public static function check(){
            if(!empty($_SESSION['user_id']) && !is_null($_SESSION['user_id']))
                return true;
            return false;
        }

        /**
         * Get the user instance
         * @return \Showcase\Models\User
         */
        public static function user(){
            if(check()){
                $user = new User();
                $user->get($_SESSION['user_id']);
                if($user != null)
                    return $user;
            }
            return null;
        }

        /**
         * Get the user name
         * @return String
         */
        public static function username(){
            if(check()){
                $user = new User();
                $user->get($_SESSION['user_id']);
                if($user != null)
                    return $user->name;
            }
            return null;
        }
    }
}