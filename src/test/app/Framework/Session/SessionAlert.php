<?php
namespace  Showcase\Framework\Session{
    
    /**
     * Session alert to save message in the session
     * So it can be displayed in the views
     */
    class SessionAlert{
        /**
         * Create a session message
         */
        public static function create($message, $message_type='info'){
            if (session_status() == PHP_SESSION_NONE)
                session_start();
            self::clear();
            if($message){
                $html = "<style>
                .info, .success, .warning, .error {
                    border: 1px solid;
                    margin: 10px 0px;
                    padding: 15px 10px 15px 50px;
                    background-repeat: no-repeat;
                    background-position: 10px center;
                }
                .info {
                    color: #00529B;
                    background-color: #BDE5F8;
                    background-image: url('https://i.imgur.com/ilgqWuX.png');
                }
                .success {
                    color: #4F8A10;
                    background-color: #DFF2BF;
                    background-image: url('https://i.imgur.com/Q9BGTuy.png');
                }
                .warning {
                    color: #9F6000;
                    background-color: #FEEFB3;
                    background-image: url('https://i.imgur.com/Z8q7ww7.png');
                }
                .error{
                    color: #D8000C;
                    background-color: #FFBABA;
                    background-image: url('https://i.imgur.com/GnyDvKN.png');
                }
                </style>
                <p class='$message_type'>$message</p>";
                $_SESSION['sess_flash_message'][] = $html;
            }
        }
        
        /**
         * Get message html
         */
        public static function show(){
            if (!isset($_SESSION)) {
                if (session_status() == PHP_SESSION_NONE)
                    session_start();
            }
            if(array_key_exists('sess_flash_message', $_SESSION) && !empty($_SESSION['sess_flash_message']) && $_SESSION['sess_flash_message'] != null)
                return $_SESSION['sess_flash_message'][0];
        }

        /**
         * Clear session
         */
        public static function clear(){
            $_SESSION['sess_flash_message'] = null;
        }
    }
}