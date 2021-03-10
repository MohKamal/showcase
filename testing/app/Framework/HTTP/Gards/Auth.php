<?php
namespace  Showcase\Framework\HTTP\Gards{
    
    use \Showcase\Framework\HTTP\Gards\IAuth;
    use \Showcase\Models\User;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Session\Session;
    use \Showcase\Framework\Session\Cookie;
    use \Showcase\Framework\Database\DB;
    
    /**
     * 
     * The Base controller with the basic includes
     * 
     */
    class Auth implements IAuth{
        
        // current user email if connected
        static $login_column = 'email';

        /**
         * Set the column to login with
         */
        public static function loginColumn($column='email'){
            self::$login_column = $column;
        }

        /**
         * Login function  with email and password, classic function
         * @param String
         * @return Boolean
         */
        public static function login($email, $password, $remember=false){
            if (empty($email) || empty($password)) {
                Log::print("Auth: Trying to log with empty coordinates");
                return false;
            }

            $user = DB::factory()->model('User')->select()->where(self::$login_column, $email)->first();

            if ($user == null) {
                Log::print("Auth: No user was found with email " . $email);
                return false;
            }
            
            if($user->validHash($password, $user->password)){
                Cookie::store('ses_user_id', $user->id, ['expires' => time() + 3600]);
                Cookie::store('ses_user_email', $user->email, ['expires' => time() + 3600]);
                Cookie::store('ses_user_name', $user->username, ['expires' => time() + 3600]);
                if($remember){
                    $token = self::generateRandomString(36);
                    DB::factory()->table('remembers')->insert(['user_id' => $user->id, 'token' => $token, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")])->run();
                    Cookie::store('ses_user_id', $user->id, ['expires' => strtotime( '+1 year' )]);
                    Cookie::store('ses_user_token', $token, ['expires' => strtotime( '+1 year' )]);
                }

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
        public static function loginWithEmail($email, $remember=false){
            if (empty($email)) {
                Log::print("Auth: Trying to log with empty coordinates");
                return false;
            }

            $user = DB::factory()->model('User')->select()->where('email', $email)->first();

            if ($user == null) {
                Log::print("Auth: No user was found with email " . $email);
                return false;
            }
            
            Cookie::store('ses_user_id', $user->id, ['expires' => time() + 3600]);
            Cookie::store('ses_user_email', $user->email, ['expires' => time() + 3600]);
            Cookie::store('ses_user_name', $user->username, ['expires' => time() + 3600]);

            if($remember){
                $token = self::generateRandomString(36);
                DB::factory()->table('remembers')->insert(['user_id' => $user->id, 'token' => $token, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")])->run();
                Cookie::store('ses_user_id', $user->id, ['expires' => strtotime( '+1 year' )]);
                Cookie::store('ses_user_token', $token, ['expires' => strtotime( '+1 year' )]);
            }

            Log::print("Auth: user connected " . $email);
            return true;
        }

        /**
         * Login function with only email
         * @param String
         * @return Boolean
         */
        public static function loginWithId($id, $remember=false){
            if (empty($id)) {
                Log::print("Auth: Trying to log with empty coordinates");
                return false;
            }

            $user = DB::factory()->model('User')->select()->where('id', $id)->first();

            if ($user == null) {
                Log::print("Auth: No user was found with id " . $id);
                return false;
            }
            
            Cookie::store('ses_user_id', $user->id, ['expires' => time() + 3600]);
            Cookie::store('ses_user_email', $user->email, ['expires' => time() + 3600]);
            Cookie::store('ses_user_name', $user->username, ['expires' => time() + 3600]);

            if($remember){
                $token = self::generateRandomString(36);
                DB::factory()->table('remembers')->insert(['user_id' => $user->id, 'token' => $token, 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")])->run();
                Cookie::store('ses_user_id', $user->id, ['expires' => strtotime( '+1 year' )]);
                Cookie::store('ses_user_token', $token, ['expires' => strtotime( '+1 year' )]);
            }

            Log::print("Auth: user connected " . $user->email);
            return true;
        }

        /**
         * Log out user if login
         * @return boolean 
         */
        public static function logout(){
            if(self::check()){
                DB::factory()->table('remembers')->delete()->where('user_id', Cookie::retrieve('ses_user_id'))->run();
                Cookie::clear('ses_user_id');
                Cookie::clear('ses_user_email');
                Cookie::clear('ses_user_name');
                Cookie::clear('ses_user_token');
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
            $config_file = dirname(__FILE__) . "/Config/config.json";
            $jsonString = file_get_contents($config_file);
            $data = json_decode($jsonString, true);
            return filter_var(strtolower($data["auth"]), FILTER_VALIDATE_BOOLEAN);
        }
        

        /**
         * Check if the user is connect
         * @return Boolean
         */
        public static function check(){
            if(!empty(Cookie::retrieve('ses_user_id')) && !is_null(Cookie::retrieve('ses_user_id')))
                return true;
            return false;
        }

        /**
         * Check if the user is not connected
         * @return Boolean
         */
        public static function guest(){
            if(empty(Cookie::retrieve('ses_user_id')) && is_null(Cookie::retrieve('ses_user_id')))
                return true;
            return false;
        }

        /**
         * Get the user instance
         * @return \Showcase\Models\User
         */
        public static function user(){
            if (!empty(Cookie::retrieve('ses_user_id')) && !is_null(Cookie::retrieve('ses_user_id'))) {
                $user = DB::factory()->model('User')->select()->where('id', Cookie::retrieve('ses_user_id'))->first();
                if (!is_null($user)) {
                    return $user;
                }
            }
            return null;
        }

        /**
         * Get the user name
         * @return String
         */
        public static function username($col='email'){
            if(self::check()){
                $user = DB::factory()->model('User')->select()->where('id', Cookie::retrieve('ses_user_id'))->first();
                if($user != null)
                    return $user->$col;
            }
            return null;
        }

        /**
         * Check if the user want to be rememberd
         */
        public static function checkRemember(){
            if (!empty(Cookie::retrieve('ses_user_id')) && !is_null(Cookie::retrieve('ses_user_id'))) {
                if (!empty(Cookie::retrieve('ses_user_token')) && !is_null(Cookie::retrieve('ses_user_token'))) {
                    $token = DB::factory()->table('remembers')->select()->where('user_id', Cookie::retrieve('ses_user_id'))->where('token', Cookie::retrieve('ses_user_token'))->first();
                    if(!empty($token) && !is_null($token)){
                        Cookie::clear('ses_user_id');
                        Cookie::clear('ses_user_token');
                        self::loginWithId(Cookie::retrieve('ses_user_id'), true);
                        return true;
                    }
                }
            }
            return false;
        }

        /**
         * Generate a string as token
         * @param int $length token lenght
         * 
         * @return string
         */
       private static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

        /**
         * Include the routes
         */
        public static function routes($router){
            include 'Config/Route/Web.php';
        }
    }
}