<?php

const DEFAULT_MSG = 'Select a command';
const DIRECTORY = './examples';
const CMD_RUN = 1;
const CMD_CREATE = 2;
const CMD_EXIT = "exit";

while (true) {
    echo <<<EOT
    Available Commands:
    1) Run example test
    2) Create new Api Object
    EOT;
    echo message("Enter a integer or 'exit' to quit:");
    $input = trim(fgets(STDIN));

    try {
        $input = match ($input) {
            (int) CMD_RUN => runExample(),
            CMD_CREATE => createApiObject(),
            CMD_EXIT  => exit(),
            default => message(DEFAULT_MSG)
        };
    } catch (\UnhandledMatchError $e) {
    }
}


function message(string $message)
{
    echo "\n" .$message . " ";
}

function runExample()
{

    getDirContent();

}

function createApiObject()
{

}

function getDirContent()
{
    if (is_dir(DIRECTORY)) {
        $contents = scandir(DIRECTORY);
    
        // Exclude . and .. (current directory and parent directory entries)
        $contents = array_diff($contents, array('.', '..'));
    
        // Now $contents contains the list of files and subdirectories in the folder
        foreach ($contents as $item) {
            echo $item . PHP_EOL;
        }
    } else {
        echo "Directory not found: " . DIRECTORY;
    }
}