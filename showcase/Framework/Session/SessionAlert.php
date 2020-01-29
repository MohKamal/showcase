<?php
namespace Showcase\Framework\Session{
    
    /**
     * Session alert to save message in the session
     * So it can be displayed in the views
     */
    class SessionAlert{
        /**
         * Create a session message
         */
        public static function Create($message, $message_type='notice'){
            session_start(); 
            if($message){
                switch($message_type){ 
                case 'success': $_SESSION['sess_flash_message'][] = '<p class="isa_success">'. $message .'</p>';break;
                case 'error': $_SESSION['sess_flash_message'][] = '<p class="isa_error">'. $message .'</p>';break;
                case 'notice': $_SESSION['sess_flash_message'][] = '<p class="isa_info">'. $message .'</p>';break;
                case 'warning': $_SESSION['sess_flash_message'][] = '<p class="isa_warning">'. $message .'</p>';break;
                default: $_SESSION['sess_flash_message'][] = $message;
                }
            }
        }

        /**
         * Get message html
         */
        public static function Show(){
            if(!isset($_SESSION))
                session_start(); 
            if(array_key_exists('sess_flash_message', $_SESSION) && !empty($_SESSION['sess_flash_message']) && $_SESSION['sess_flash_message'] != null)
                return $_SESSION['sess_flash_message'];
        }

        /**
         * Clear session
         */
        public static function Clear(){
            $_SESSION['sess_flash_message'] = null;
        }
    }
}