<?php
namespace  Showcase\Framework\HTTP\Routing{
    /**
     * More at : https://medium.com/the-andela-way/how-to-build-a-basic-server-side-routing-system-in-php-e52e613cf241
     */
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\HTTP\Routing\IRequest;

    class Request implements IRequest
    {
        public function __construct()
        {
            $this->bootstrapSelf();
        }

        private function bootstrapSelf()
        {
            foreach ($_SERVER as $key => $value) {
                $this->{$this->toCamelCase($key)} = $value;
            }
        }
        
        private function toCamelCase($string)
        {
            $result = strtolower($string);
            preg_match_all('/_[a-z]/', $result, $matches);
            foreach ($matches[0] as $match) {
                $c = str_replace('_', '', strtoupper($match));
                $result = str_replace($match, $c, $result);
            }
            return $result;
        }

        public function get()
        {
            if ($this->requestMethod === "GET") {
                $body = array();
                foreach ($_GET as $key => $value) {
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                
                $url = "//{$this->httpHost}{$this->requestUri}";
                $query_str = parse_url($url, PHP_URL_QUERY);
                parse_str($query_str, $query_params);
                foreach ($query_params as $key => $value) {
                    $body[$key] = $value;
                }
                return $body;
            }
            if ($this->requestMethod == "POST") {
                $body = array();
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $data = array();
                        foreach ($value as $k => $v) {
                            if(is_array($v)){
                                $value[$k] = $v;
                            }else
                                $value[$k] = filter_input(INPUT_POST, $k, FILTER_SANITIZE_SPECIAL_CHARS);
                        }
                        $body[$key] = $value;
                    }
                    else
                        $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                return $body;
            }
        }
    }
}
