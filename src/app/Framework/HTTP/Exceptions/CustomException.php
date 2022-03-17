<?php

namespace Showcase\Framework\HTTP\Exceptions{

    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Initializer\VarLoader;

    abstract class CustomException extends \Exception implements IException
    {
        protected $message = 'Unknown exception';     // Exception message
        private   $string;                            // Unknown
        protected $code    = 0;                       // User-defined exception code
        protected $file;                              // Source filename of exception
        protected $line;                              // Source line of exception
        private   $trace;                             // Unknown
        private   $previous;                          // exception précédente (depuis PHP 5.3)
        private $display_as_html = true;

        public function __construct($message = null, $code = ExecptionEnum::DEFAULT)
        {
            if (!$message) {
                throw new $this('Unknown '. get_class($this));
            }
            parent::__construct($message, $code);
        }

        public function __toString()
        {
            $this->log(); // Log to file
            if(filter_var(strtolower(VarLoader::env('DEBUG')), FILTER_VALIDATE_BOOLEAN)) { // Check if the user want to display the exception
                echo $this->html();
            }
            /* return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                    . "{$this->getTraceAsString()}"; */
            return '';
        }

        /**
         * Save the exception to the log files
         */
        private function log() {
            $log = get_class($this) . " '{$this->message}' in {$this->file}({$this->line})";
            Log::print($log);
            foreach ($this->getTrace() as $trace) {
                $trace_log = '';
                if(isset($trace['class']))
                $trace_log .= $trace['class'];
                if(isset($trace['function']))
                    $trace_log .= '::' . $trace['function'];

                if(isset($trace['file']))
                    $trace_log .= "\n" . $trace['file'];
                if(isset($trace['line']))
                    $trace_log .= '(' . $trace['line'] . ')';
                
                Log::print($trace_log);
            }
        }

        /**
         * Return the exeption html page to be displayed
         * 
         * @return string $page html
         */
        private function html() {
            $page = '<!DOCTYPE html>
            <html>
            <head>
            <meta charset="utf-8">
            <title>Showcase</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="./images/favicon.ico" />
            <!-- STYLE CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.2/styles/atom-one-dark.min.css">
            </head>
            <body style="overflow: hidden;">
            <div class="container-fluid">
            <div class="row">
            <aside class="col-4" style="max-width: 30%; overflow: scroll; background-color: gray; padding: 0; margin-right: 10px;">
            <div style="padding: 10px; background-color: #343434; color: white;">
            <p><span style="color:red;">' . get_class($this);
            $page .= '</span> (ERROR)</p><p>' . $this->message;
            $page .= '</p></div><div class="d-flex flex-column" style="margin-top: 20px;">';
            foreach($this->getTrace() as $trace){
                $page .= '<article style="padding: 10px; margin: 5px; background-color: #b3b3b3; border-radius: 8px;"><p style="padding: 0; margin: 0;">';
                
                if(isset($trace['class']))
                    $page .= $trace['class'];
                
                $page .= ' => ';
                
                if(isset($trace['function']))
                    $page .= $trace['function'];

                $page .= '</p>
                <p style="color:gray; font-size: 10px;">';
                if(isset($trace['file']))
                    $page .= $trace['file'];
                $page .= ' (';
                if(isset($trace['line']))
                    $page .= $trace['line'];
                $page .= ') </p> </article>';
            }
                                
                $page .= '</div></aside>
                        <!-- Center -->
                        <section class="col-8" style="margin: 0; padding: 0;">
                        <div class="row">
                        <h4 style="font-weight: lighter; font-size: 10px; text-align: center;">Showcase</h4>
                        </div>
                        <div class="" style="background-color: #343434; color: white; height: 100vh;">
                        <div class="docs-code-block">
                        <pre class="shadow-lg rounded"><code class="php hljs" data-ln-start-from="312">';
                $code = $this->getFileCode();
                $page .= $code['code'];
                $page .= '</code></pre>
                        </div>
                        </div>
                        </section>
                        </div>
                        </div>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.8/highlight.min.js"></script>
                        <script src="https://cdn.jsdelivr.net/gh/TRSasasusu/highlightjs-highlight-lines.js@1.2.0/highlightjs-highlight-lines.min.js"></script>
                        <script>
                            hljs.initHighlightingOnLoad();';
                    $lineNumber = $code['line'];
                    $page .= "\nhljs.initHighlightLinesOnLoad([
                                [{start: {$lineNumber}, end: {$lineNumber}, color: 'rgba(255, 0, 0, 0.2)'},], // Highlight some lines in the second code block.
                            ]);";
                    $page .= '$(document).ready(function() {
                                $("b").hide();
                                $("br").hide();
                            });
                        </script>
                        </body>
                        </html>';

            return $page;
        }

        /**
         * Open the file where the execption occured and get the code to be shown in the html page
         * 
         * @return array $line to be colored and $code to be displayed
         */
        private function getFileCode() {
            $offsetLines = 30;
            $firstTrace = $this->getTrace()[0];
            $file = $this->file;
            $fileLine = $this->line;
            if (isset($firstTrace['file'])) {
                if (file_exists($firstTrace['file'])) {
                    $file = $firstTrace['file'];
                    if(isset($firstTrace['line']))
                        $fileLine = intval($firstTrace['line']);
                    else{
                        $file = $this->file;
                    }
                }
            }

            $lines = file($file);
            $start = 2;
            if($fileLine > $offsetLines)
                $start = $fileLine - $offsetLines;
            $end = $fileLine + $offsetLines;
            if($end > count($lines))
                $end = count($lines);

            $store = [];
            $found = false;
            $lineNumber = 0;
            for($i = $start-1; $i< $end-1; $i++) {
                $store[] = ($i + 1) . '. ' . $lines[$i];
                if($i+1 == $fileLine)
                    $found = true;
                if(!$found)
                    $lineNumber++;
            }

            return ['line' => $lineNumber, 'code' => implode("", $store)];
        }
    }
}