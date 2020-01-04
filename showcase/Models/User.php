<?php
namespace Showcase\Models{
    use Showcase\Framwork\IO\CSVHandler;
    use \Showcase\AutoLoad;
    use \Exception;
    
    class User
    {
        public $username;
        public $email;
        public $first_name;
        public $last_name;
        public $password;
        //public static $File = env('CVS_USER'); //user csv file, can be changed in env.php

        public function __get($var) {
            throw new Exception("Invalid property $var");
        }

        public function __set($var, $value) {
            $this->__get($var);
        }

        public function __construct($username, $email, $password){
            $this->username = strtolower($username);
            $this->password = password_hash($password, PASSWORD_BCRYPT);
            $this->email = strtolower($email);
        }

        /**
         * Save to file
         */
        public function save(){
            // Verify if the email not exist and then add it
            //
            // Add Code here
            //
            // Saving to file
            CSVHandler::Write(AutoLoad::env('CSV_USER'), [$this->username, $this->email, $this->password]);
        }

        /**
         * Get a user by its email
         */
        public static function getByEmail($email){
            // Extract all users data
            $data = CSVHandler::Read(AutoLoad::env('CSV_USER'));
            // Loop for the specific user
            foreach($data as $line){
                if($line[1] == strtolower($email)){
                    $user = new User($line[0], $line[1], $line[2]);
                    $user->password = $line[2];
                    return $user;
                }
            }
            return null;
        }

        /**
         * Get current auth user
         */
        public static function Current(){
            if(!isset($_SESSION))
                session_start(); 
            if(array_key_exists('user', $_SESSION) && !empty($_SESSION['user']))
                    return unserialize($_SESSION['user']);
        }

    }

}