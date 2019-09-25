<?php

namespace Lotos\Phoenix;

class Dictionary
{
    const EXIT_COMMAND = 'exit';

    protected $mainDictionary = [
        'list', 'load', 'get', 'go', 'put', 'parse', 'paint', 'delete', 'download', self::EXIT_COMMAND
    ];

    protected $subDictionary = [
        'level', 'library', 'document', 'dragon', 'daemon', 'data', 'port', 'password', 'paragraph'
    ];

    private $promptLine = '> ';

    public function initCommandCompletion()
    {
        if (function_exists('readline_completion_function')) {
            readline_completion_function(
                function ($currWord, $stringPosition, $cursorInLine) {
                    $fullLine = readline_info()['line_buffer'];

                    if (count( explode(' ', $fullLine) ) > 2 ) {
                        return [];
                    }
                    if (strrpos($fullLine, ' ') !== false &&
                        ( strrpos($fullLine, $currWord) ===  false || strrpos($fullLine, ' ') < strrpos($fullLine, $currWord)) ) {
                        return $this->subDictionary;
                    }

                    return $this->mainDictionary;
                }
            );
        }
    }


    public function readCommand()
    {
        if (function_exists('readline')) {
            $command = readline($this->promptLine);
        } else {
            fputs(STDOUT, $this->promptLine);
            $command = fgets(STDIN);
        }
        return $command;
    }


    public function executeCommand($command)
    {
        $param = '';
        if (strpos($command, ' ') !== false) {
            list ($command, $param) = explode(' ', $command, 2);
        }

        if (!$this->isCommandExists($command)) {
            fputs(STDOUT, "Hey! I don't know what are you talking about!\n");
            return false;
        }
        $message = "You try to run command '{$command}'";
        if (!empty($param)) {
            $message .= " and with param '{$param}'.";
        }

        fputs(STDOUT, $message . "\n");
        return true;
    }


    private function isCommandExists($command)
    {
        return in_array($command, array_merge($this->mainDictionary, $this->subDictionary));
    }

}
