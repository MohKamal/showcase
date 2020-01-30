<?php
/**
 * Command line executer
 * example: php Creator.php function_name arg
 */
namespace Showcase{
    require_once dirname(__FILE__) . '\autoload.php';
    require_once dirname(__FILE__) . '\Framework\Command\Cmd.php';
    
    use \Showcase\AutoLoad;

    AutoLoad::register();
    
    use \Showcase\Framework\Command\Cmd;

    Extract($argv);

    /**
     * Extract the command
     * @param array @argv from the command line
     */
    function Extract($command){
        $cmd = new Cmd();
            if($command[0] != 'Creator.php')
                return false;
        $param = '';
        if(array_key_exists(2, $command))
            $param = $command[2];
        if(method_exists($cmd, $command[1])){
            call_user_func( array($cmd,$command[1]), $param);
        }
    }
}