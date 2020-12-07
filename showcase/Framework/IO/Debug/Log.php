<?php
namespace Showcase\Framework\IO\Debug {
    /**
     * Create log files to Storage/Logs
     */
    class Log
    {
        /**
         * Print a message to the day files
         * @param sring/array message to display
         */
        public static function print($message){
            //$log = Log::UserVerification();
            $log = '';
            if(is_array($message)){
                $log .=  date('h:i', time()).PHP_EOL;
                $log .= '------------------------------------'.PHP_EOL;
                $log = serialize($message);
                $log .= '------------------------------------'.PHP_EOL;
            }else{
                $log .= date('h:i', time()) . ' - ' . $message.PHP_EOL;
            }
            //Save string to log, use FILE_APPEND to append.
            file_put_contents(dirname(__FILE__) . '/../../../Storage/logs/log_'.date("j.n.Y").'.log', $log.PHP_EOL, FILE_APPEND);
        }

        /**
         * Print a message to the console server
         * @param string/array message to display
         */
        public static function console($message){
            //$log = Log::UserVerification();
            $log = '';
            if(is_array($message)){
                $log .=  date('h:i', time()).PHP_EOL;
                $log .= '------------------------------------'.PHP_EOL;
                $log = serialize($message);
                $log .= '------------------------------------'.PHP_EOL;
            }else{
                $log .= date('h:i', time()) . ' - ' . $message.PHP_EOL;
            }

            echo $log;
        }

        /**
         * Log closure to the day file
         * @param Closure
         */
        public static function closure_dump(Closure $c) {
            $str = 'function (';
            $r = new ReflectionFunction($c);
            $params = array();
            foreach($r->getParameters() as $p) {
                $s = '';
                if($p->isArray()) {
                    $s .= 'array ';
                } else if($p->getClass()) {
                    $s .= $p->getClass()->name . ' ';
                }
                if($p->isPassedByReference()){
                    $s .= '&';
                }
                $s .= '$' . $p->name;
                if($p->isOptional()) {
                    $s .= ' = ' . var_export($p->getDefaultValue(), TRUE);
                }
                $params []= $s;
            }
            $str .= implode(', ', $params);
            $str .= '){' . PHP_EOL;
            $lines = file($r->getFileName());
            for($l = $r->getStartLine(); $l < $r->getEndLine(); $l++) {
                $str .= $lines[$l];
            }
            Log::print($str);
        }
    }
}