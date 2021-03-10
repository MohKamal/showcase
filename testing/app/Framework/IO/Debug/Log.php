<?php
namespace  Showcase\Framework\IO\Debug {
    use \Showcase\Framework\IO\Storage\Storage;
    /**
     * Create log files to Storage/Logs
     */
    class Log
    {
        private static $foreground_colors = array();
        private static $background_colors = array();
        
        private static function addColors() {
			// Set up shell colors
			self::$foreground_colors['black'] = '0;30';
			self::$foreground_colors['dark_gray'] = '1;30';
			self::$foreground_colors['blue'] = '0;34';
			self::$foreground_colors['light_blue'] = '1;34';
			self::$foreground_colors['green'] = '0;32';
			self::$foreground_colors['light_green'] = '1;32';
			self::$foreground_colors['cyan'] = '0;36';
			self::$foreground_colors['light_cyan'] = '1;36';
			self::$foreground_colors['red'] = '0;31';
			self::$foreground_colors['light_red'] = '1;31';
			self::$foreground_colors['purple'] = '0;35';
			self::$foreground_colors['light_purple'] = '1;35';
			self::$foreground_colors['brown'] = '0;33';
			self::$foreground_colors['yellow'] = '1;33';
			self::$foreground_colors['light_gray'] = '0;37';
            self::$foreground_colors['white'] = '1;37';
            self::$foreground_colors['default'] = '0;39';

			self::$background_colors['black'] = '40';
			self::$background_colors['red'] = '41';
			self::$background_colors['green'] = '42';
			self::$background_colors['yellow'] = '43';
			self::$background_colors['blue'] = '44';
			self::$background_colors['magenta'] = '45';
			self::$background_colors['cyan'] = '46';
            self::$background_colors['light_gray'] = '47';
            self::$background_colors['default'] = '49';
        }

        // Returns colored string
		public static function getColoredString($string, $foreground_color = null, $background_color = null) {
			$colored_string = "";

			// Check if given foreground color found
			if (isset(self::$foreground_colors[$foreground_color])) {
				$colored_string .= "\033[" . self::$foreground_colors[$foreground_color] . "m";
			}
			// Check if given background color found
			if (isset(self::$background_colors[$background_color])) {
				$colored_string .= "\033[" . self::$background_colors[$background_color] . "m";
			}

			// Add string and end coloring
			$colored_string .=  $string . "\033[0m";

			return $colored_string;
		}
        
        /**
         * Print a message to the day files
         * @param sring/array message to display
         */
        public static function print($message){
            //$log = Log::UserVerification();
            $log = '';
            if(is_array($message)) {
                $log .= date('h:i', time()) . ' - Array => [ '.PHP_EOL;
                foreach($message as $k => $v){
                    $log .= "$k => $v".PHP_EOL;
                }
                $log .= ' ]'.PHP_EOL;
            } else {
                $log .= date('h:i', time()) . ' - ' . $message.PHP_EOL;
            }
            //Save string to log, use FILE_APPEND to append.
            Storage::folder('logs')->append('log_'.date("j.n.Y").'.log', $log);
        }

        /**
         * Print a message to the console server
         * @param string/array message to display
         */
        public static function console($message, $type="info"){
            //$log = Log::UserVerification();
            $color = "default";
            $back = "default";
            switch($type){
                case 'error':
                    $back = 'red';
                    break;
                case 'warning':
                    $color = "black";
                    $back = 'yellow';
                    break;
                case 'success':
                    $color = "black";
                    $back = 'green';
                    break;
                case 'info':
                    $color = "default";
                    $back = "default";
                    break;
            }
            $log = '';
            if(is_array($message)){
                $log .= '------------------------------------'.PHP_EOL;
                $log .=  date('h:i', time()).PHP_EOL;
                $log .=  implode("\n", $message);
                $log .= '------------------------------------'.PHP_EOL;
            }else{
                $log .= date('h:i', time()) . ' - ' . $message;
            }
            self::addColors();
            echo self::getColoredString($log, $color, $back);
        }

        /**
         * Log closure to the day file
         * @param Closure
         */
        public static function closure_dump(Closure $c) {
            $str = 'function (';
            $r = new \ReflectionFunction($c);
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
            self::print($str);
        }

        /**
         * Display a var_dump to a log file
         * @param mixed $data
         */
        public static function var_dump($data, $tofile=true){
            //Capture the var_dump
            ob_start();
            var_dump($data);
            $result = ob_get_clean();
            //printed to the file
            if($tofile)
                self::print($result);
            else
                self::console($result);
        }
    }
}