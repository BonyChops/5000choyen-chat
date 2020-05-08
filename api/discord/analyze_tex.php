<?php
require_once(__DIR__.'/../../generate.php');
require_once(__DIR__.'/../imgur/upload.php');

$message_text =  $argv[1];

$comPos = 0;


if(($comPos = strpos($message_text,"!tex")) !== FALSE){
    $command = substr($message_text, $comPos + 4);
    $result = Generate_tex(trim($command));

    if($result){
        echo "good";
    }else{
        if(file_exists(__DIR__.'/../../result.png')) unlink(__DIR__.'/../../result.png');
    }
    exit;
}

if(($comPos = strpos($message_text,"!md")) !== FALSE){
    $command = substr($message_text, $comPos + 3);
    $result = Generate_tex(trim($command), true);

    if($result){
        echo "good";
    }else{
        if(file_exists(__DIR__.'/../../result.png')) unlink(__DIR__.'/../../result.png');
    }
    exit;
}