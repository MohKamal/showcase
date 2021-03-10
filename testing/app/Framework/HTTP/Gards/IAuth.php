<?php
namespace  Showcase\Framework\HTTP\Gards{
    
    interface IAuth {

        /**
         * Set the column to login with
         */
        public static function loginColumn($column='email');

        /**
         * Login function  with email and password, classic function
         * @param String
         * @return Boolean
         */
        public static function login($email, $password, $remember=false);

        /**
         * Login function with only email
         * @param String
         * @return Boolean
         */
        public static function loginWithEmail($email, $remember=false);

        /**
         * Login function with only email
         * @param String
         * @return Boolean
         */
        public static function loginWithId($id, $remember=false);

        /**
         * Log out user if login
         * @return boolean 
         */
        public static function logout();

        /**
         * Check if auth is used or not
         * @return boolean
         */
        public static function checkAuth();
        

        /**
         * Check if the user is connect
         * @return Boolean
         */
        public static function check();

        /**
         * Check if the user is not connected
         * @return Boolean
         */
        public static function guest();

        /**
         * Get the user instance
         * @return \Showcase\Models\User
         */
        public static function user();

        /**
         * Get the user name
         * @return String
         */
        public static function username($col='email');

        /**
         * Check if the user want to be rememberd
         */
        public static function checkRemember();

        /**
         * Include the routes
         */
        public static function routes($router);
    }
}