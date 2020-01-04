<?php
namespace Showcase\Framwork\IO\Debug {
    use \Showcase\AutoLoad;
    use \Showcase\Models\User;
    
    class Log
    {
        private static function UserVerification(){
            $log = "";
            if (User::Current() != null) {
                $log  = "User: ". User::Current()->email;
            }else{
                $log = "Anonymous";
            }
            $log  .= ' - '.date("F j, Y, g:i a").PHP_EOL;

            return $log;
        }

        public static function print($message){
            $log = Log::UserVerification();
            if(is_array($message)){
                $log .= '------------------------------------'.PHP_EOL;
                $log = serialize($message);
                $log .= '------------------------------------'.PHP_EOL;
            }else{
                $log .= $message.PHP_EOL;
            }
            //Save string to log, use FILE_APPEND to append.
            file_put_contents(AutoLoad::env('LOG_FOLDER') . './log_'.date("j.n.Y").'.log', $log.PHP_EOL, FILE_APPEND);
        }

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