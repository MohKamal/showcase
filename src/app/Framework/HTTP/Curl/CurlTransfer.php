<?php

namespace Showcase\Framework\HTTP\Curl{
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\IO\Storage\Storage;

    /**
     * This class is used to get data with the curl
     * Example : 
     *  $curl = new CurlTransfer(['url' => 'example.com', 'referer' => 'example.com']);
     *  $curl->createCurl();
     *  var_dump($curl); // Return String
     */
    class CurlTransfer {
        protected $_useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1';
        protected $_url;
        protected $_followlocation;
        protected $_timeout;
        protected $_maxRedirects;
        protected $_cookieFileLocation = './cookie.txt';
        protected $_post;
        protected $_postFields;
        protected $_referer ="http://www.google.com";
        protected $_binary;
        protected $_header;

        protected $_session;
        protected $_webpage;
        protected $_includeHeader;
        protected $_noBody;
        protected $_status;
        protected $_binaryTransfer;
        public    $authentication = 0;
        public    $auth_name      = '';
        public    $auth_pass      = '';

        /**
         * Use auth in the curl request
         * 
         * @param bool $use
         */
        public function useAuth($use){
            $this->authentication = 0;
            if($use == true) $this->authentication = 1;
        }

        /**
         * Set the auth username
         * 
         * @param string $name
         */
        public function setName($name){
            $this->auth_name = $name;
        }

        /**
         * Set the password for the auth request
         * 
         * @param string $pass
         */
        public function setPass($pass){
            $this->auth_pass = $pass;
        }

        /**
         * CurlTransfer construct
         * @param array Args
         *   Example : 
         *             $curl = new CurlTransfer(['url' => 'https://www.google.com']);
         */
        public function __construct(array $args=array())
        {
            $this->_url = "example.com";
            $this->_followlocation = true;
            $this->_timeout = 30;
            $this->_maxRedirects = 4;
            $this->_noBody = false;
            $this->_includeHeader = false;
            $this->_binaryTransfer = false;
            $this->_binary = false;
            $this->_header = ['Expect:'];
            foreach($args as $key => $value){
                $var = "_" . $key;
                $this->$var = $value;
            }
            $this->_cookieFileLocation = Storage::folder('cookies')->path('cookie.txt');
        }

        /**
         * Set the curl referer
         * 
         * @param string $referer
         */
        public function setReferer($referer){
            $this->_referer = $referer;
        }

        /**
         * Set request Header options
         * 
         * @param array $header
         * Example : 
         *      $header[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp'
         *      $header[] = 'Accept-Language: fr,fr-FR;q=0.8,en-US;q=0.5,en;q=0.3';
         *      $curl = new CurlTransfer(['url' => 'https://www.google.com', 'header' => $header]);
         * 
         */
        public function setHeader($header=array()){
            $this->_header = $header;
        }

        /**
         * Set cookie file location
         * @param string $path
         */
        public function setCookiFileLocation($path)
        {
            $this->_cookieFileLocation = $path;
        }

        /**
         * Set curl request to POST with Fields
         * 
         * @param array $postFields
         */
        public function setPost ($postFields)
        {
            $this->_post = true;
            $this->_postFields = $postFields;
        }

        /**
         * Set curl userAgent
         * 
         * @param string $userAgent
         */
        public function setUserAgent($userAgent)
        {
            $this->_useragent = $userAgent;
        }

        /**
         * Set curl to get binary data
         * 
         * @param bool $binary
         */
        public function setBinary($binary)
        {
            $this->_binary = $binary;
        }

        /**
         * Create and execute the curl request
         * 
         * @param string $url
         */
        public function createCurl($url = 'null')
        {
            if($url != 'null'){
                $this->_url = $url;
            }

            $s = curl_init();

            curl_setopt($s,CURLOPT_URL,$this->_url);
            curl_setopt($s,CURLOPT_HTTPHEADER,$this->_header);
            curl_setopt($s,CURLOPT_TIMEOUT,$this->_timeout);
            curl_setopt($s,CURLOPT_MAXREDIRS,$this->_maxRedirects);
            curl_setopt($s,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($s,CURLOPT_FOLLOWLOCATION,$this->_followlocation);
            curl_setopt($s,CURLOPT_COOKIEJAR,$this->_cookieFileLocation);
            curl_setopt($s,CURLOPT_COOKIEFILE,$this->_cookieFileLocation);
            curl_setopt($s, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($s, CURLOPT_SSL_VERIFYHOST, false);

            if($this->authentication == 1){
                curl_setopt($s, CURLOPT_USERPWD, $this->auth_name.':'.$this->auth_pass);
            }
            if($this->_post)
            {
                curl_setopt($s,CURLOPT_POST,true);
                curl_setopt($s,CURLOPT_POSTFIELDS,$this->_postFields);
            }

            if($this->_includeHeader)
            {
                curl_setopt($s,CURLOPT_HEADER,true);
            }

            if($this->_noBody)
            {
                curl_setopt($s,CURLOPT_NOBODY,true);
            }
            
            if($this->_binary)
            {
                curl_setopt($s,CURLOPT_BINARYTRANSFER,true);
            }
            
            curl_setopt($s,CURLOPT_USERAGENT,$this->_useragent);
            curl_setopt($s,CURLOPT_REFERER,$this->_referer);

            $this->_webpage = curl_exec($s);
            $this->_status = curl_getinfo($s,CURLINFO_HTTP_CODE);
            curl_close($s);
        }

        /**
         * Get the curl request Status after createCurl
         * 
         * @return string status
         */
        public function getHttpStatus()
        {
            return $this->_status;
        }

        /**
         * toString to return the curl results
         * 
         * @return string curl Results
         */
        public function __toString(){
            return $this->_webpage;
        }

        /**
         * Save the curl results to file
         * 
         * @param string $filename
         * 
         * @return string $filename
         */
        public function toFile($filename=""){
            if(empty($filename) || null($filename))
                $filename = time() . ".html";
            Storage::folder('app')->put($filename, $this->_webpage);
            return $filename;
        }
   } 
}