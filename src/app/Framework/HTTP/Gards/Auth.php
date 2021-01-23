<?php
namespace  Showcase\Framework\HTTP\Gards{
    
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Models\User;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Session\Session;
    use \Showcase\Framework\Database\DB;
    
    /**
     * 
     * The Base controller with the basic includes
     * 
     */
    class Auth{
        
        // current user email if connected
        static $ses_user_email = null;
        static $ses_user_name = null;

        /**
         * Login function  with email and password, classic function
         * @param String
         * @return Boolean
         */
        public static function login($email, $password){
            if (empty($email) || empty($password)) {
                Log::print("Auth: Trying to log with empty coordinates");
                return false;
            }

            $user = DB::model('User')->select()->where('email', $email)->first();

            if ($user == null) {
                Log::print("Auth: No user was found with email " . $email);
                return false;
            }
            
            if($user->validHash($password, $user->password)){
                Session::store('ses_user_id', $user->id, 3600);
                Session::store('ses_user_email', $user->email, 3600);
                Session::store('ses_user_name', $user->username, 3600);
                Session::store('ses_auth', true);
                Log::print("Auth: user connected " . $email);
                return true;
            }
            Log::print("Auth: Wrong password for " . $email);
            return false;
        }

        /**
         * Login function with only email
         * @param String
         * @return Boolean
         */
        public static function loginWithEmail($email){
            if (empty($email)) {
                Log::print("Auth: Trying to log with empty coordinates");
                return false;
            }

            $user = DB::model('User')->select()->where('email', $email)->first();

            if ($user == null) {
                Log::print("Auth: No user was found with email " . $email);
                return false;
            }
            
            Session::store('ses_user_id', $user->id, 3600);
            Session::store('ses_user_email', $user->email, 3600);
            Session::store('ses_user_name', $user->username, 3600);
            Session::store('ses_auth', true);
            Log::print("Auth: user connected " . $email);
            return true;
        }

        /**
         * Log out user if login
         * @return boolean 
         */
        public static function logout(){
            if(self::check()){
                Session::clear('ses_user_id');
                Session::clear('ses_user_email');
                Session::clear('ses_user_name');
                Session::clear('ses_auth');
                if(!self::check())
                    return true;
            }

            return false;
        }

        /**
         * Check if auth is used or not
         * @return boolean
         */
        public static function checkAuth(){
            if(is_null(Session::retrieve('ses_auth')))
                return false;
            if(empty(Session::retrieve('ses_auth')))
                return false;
            if(Session::retrieve('ses_auth') === false)
                return false;
                
            return true;
        }

        /**
         * Check if the user is connect
         * @return Boolean
         */
        public static function check(){
            if(is_null(self::user()))
                return false;
            if(!empty(Session::retrieve('ses_user_id')) && !is_null(Session::retrieve('ses_user_id')))
                return true;
            return false;
        }

        /**
         * Check if the user is not connected
         * @return Boolean
         */
        public static function guest(){
            if(is_null(self::user()))
                return true;
            if(empty(Session::retrieve('ses_user_id')) && is_null(Session::retrieve('ses_user_id')))
                return true;
            return false;
        }

        /**
         * Get the user instance
         * @return \Showcase\Models\User
         */
        public static function user(){
            if (!empty(Session::retrieve('ses_user_id')) && !is_null(Session::retrieve('ses_user_id'))) {
                $user = DB::model('User')->select()->where('id', Session::retrieve('ses_user_id'))->first();
                if (is_null($user)) {
                    return null;
                }
                return $user;
            }
            return null;
        }

        /**
         * Get the user name
         * @return String
         */
        public static function username($col='email'){
            if(self::check()){
                $user = DB::model('User')->select()->where('id', Session::retrieve('ses_user_id'))->first();
                if($user != null)
                    return $user->$col;
            }
            return null;
        }

        /**
         * Include the routes
         */
        public static function routes($router){
            include 'Config/Route/Web.php';
        }
    }
}