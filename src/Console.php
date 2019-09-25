<?php

namespace Lotos\Phoenix;

class Console
{
    public static $wait;

    public function run() {
        echo "\033[39m".'        Welcome to darkside of Power'."\n".
        "\033[31m         (
         )\ )    )
        (()/( ( /(         (        (      )
         /(_)))\())  (    ))\  (    )\  ( /(
        (_)) ((_)\   )\  /((_) )\ )((_) )\()) \033[33m
        | _ \| |\033[31m(_) ((_)(_))  _(_/( (_)((_)\  \033[33m
        |  _/| ' \ / _ \/ -_)| ' \ \033[31m)\033[33m| |\ \ /
        |_|  |_||_|\___/\___||_||_| |_|/_\_\ \033[37m
        \033[32mYou can use Power of Phoenix, but Cthulhu is watching you... \033[37m\n\n";
        self::$wait = true;
        echo "\033[34mcommand> \033[35m";
    }

    public function runCommand($in) {
        $command = trim($in);
        if($command == 'quit' || $command == 'exit') {
          self::$wait = false;
          echo "Ktulhu waiting you later!\033[39m".PHP_EOL;
          exit;
        }
        if(strpos($command, ' ')) {
            $args = explode(' ', $command);
            $class = __NAMESPACE__.'\\'.ucfirst(array_shift($args));
            $method = array_shift($args);
            foreach($args as $k => $arg) {
              if(strpos($arg, '[') !== false) {
                $str = rtrim(ltrim($arg, '['), ']');
                $args[$k] = explode(',', $str);
              }
            }
          call_user_func_array([new $class, $method], $args);
        } else {
          $class = __NAMESPACE__.'\\'.ucfirst($command);
          echo $class;
        }
        echo PHP_EOL."\033[34mcommand> \033[35m";
    }

}
