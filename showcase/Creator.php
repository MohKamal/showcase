<?php

namespace Showcase{
    require_once dirname(__FILE__) . '\autoload.php';
    require_once dirname(__FILE__) . '\Framework\Command\Cmd.php';
    
    use \Showcase\AutoLoad;

    AutoLoad::register();
    
    use \Showcase\Framework\Command\Cmd;

    Extract($argv);

    function Extract($command){
        $cmd = new Cmd();
            if($command[0] != 'Creator.php')
                return false;
        if(method_exists($cmd, $command[1])){
            call_user_func( array($cmd,$command[1]), $command[2]);
        }
    }
}