<?php
namespace  Showcase\Framework\HTTP\Gards{
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Session\Session;
    
    class CSRF { 

        /**
         * Var to check if the page was already check it for CSRF
         */
        protected $launched = false;

        /**
         * Start injection for a page, if not done before
         */
        function start(){
            if (!$this->launched) {
                $this->launched = true;
                $this->csrfguard_start();
            }
        }

        /**
         * Store token or name to session
         */
        function store_in_session($key,$value)
        {
            Session::store($key, $value);
        }

        /**
         * Clean the session from token or name
         */
        function unset_session($key)
        {
            Session::clear($key);
        }

        /**
         * Get token or name from session
         * 
         * @return string
         */
        function get_from_session($key)
        {
            return Session::retrieve($key);
        }

        /**
         * Generate a string as token
         * @param int $length token lenght
         * 
         * @return string
         */
       function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        /**
         * Generate the token for a form
         * @param string $unique_form_name form name
         * 
         * @return string
         */
        function csrfguard_generate_token($unique_form_name)
        {
            $token = $this->generateRandomString(64); // PHP 7, or via paragonie/random_compat
            $this->store_in_session($unique_form_name,$token);
            return $token;
        }
        
        /**
         * Valid existing token
         * @param string $unique_form_name form name
         * @param string $token_value token
         * 
         * @return boolean
         */
        function csrfguard_validate_token($unique_form_name,$token_value)
        {
            $token = $this->get_from_session($unique_form_name);
            if (!is_string($token_value))
                return false;
            $result = false;
            if(strcmp($token, $token_value) === 0)
                $result = true;
            //$this->unset_session($unique_form_name);
            return $result;
        }

        /**
         * Search for forms in a page, and add token inputs
         * 
         * @param string $form_data_html page html
         * 
         * @return string
         */
        function csrfguard_replace_forms($form_data_html)
        {
            $count = preg_match_all("/<form(.*?)>(.*?)<\\/form>/is",$form_data_html,$matches,PREG_SET_ORDER);
            if (is_array($matches))
            {
                foreach ($matches as $m)
                {
                    if (strpos($m[1],"nocsrf")!==false) { continue; }
                    $name="CSRFGuard_".mt_rand(0,mt_getrandmax());
                    $token=$this->csrfguard_generate_token($name);
                    $form_data_html=str_replace($m[0],
                        "<form{$m[1]}>
                        <input type='hidden' name='CSRFName' value='{$name}' />
                        <input type='hidden' name='CSRFToken' value='{$token}' />{$m[2]}</form>",
                    $form_data_html);
                }
            }
            return $form_data_html;
        }

        /**
         * Get CRSF inputs
         * 
         * @return string
         */
        function csrfguard_get_inputs()
        {
            $name="CSRFGuard_".mt_rand(0,mt_getrandmax());
            $token = $this->csrfguard_generate_token($name);
            $inputs="<input type='hidden' name='CSRFName' value='{$name}' /><input type='hidden' name='CSRFToken' value='{$token}' />";
            return $inputs;
        }

        /**
         * inject the inputs to the forms
         */
        function csrfguard_inject()
        {
            if (session_status() == PHP_SESSION_NONE)
                session_start(); //if you are copying this code, this line makes it work.
            $data=ob_get_clean();
            $data=$this->csrfguard_replace_forms($data);
            echo $data;
        }
        
        /**
         * Start CSRF injection
         */
        function csrfguard_start()
        {
            ob_start();
            /* adding double quotes for "csrfguard_inject" to prevent: 
                Notice: Use of undefined constant csrfguard_inject - assumed 'csrfguard_inject' */
            register_shutdown_function([$this, "csrfguard_inject"]);	
        }
    }
}
