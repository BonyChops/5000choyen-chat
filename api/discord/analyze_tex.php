<?php
require_once(__DIR__.'/../../generate.php');
require_once(__DIR__.'/../imgur/upload.php');

$message_text =  $argv[1];

$comPos = 0;


if(($comPos = strpos($message_text,"!tex")) !== FALSE){
    $command = substr($message_text, $comPos + 4);
    $result = Generate_tex(trim($command));

    if($result){
        $img = file_get_contents(__DIR__."/../../result.png");
        $response_format_text = [returnImgurIds($img)];
    }else{
        $response_format_text = [[
            "type"=> "text",
            "text"=> "あれ？www\nTeXコマンドミスってますけど？wwwwwwwwwwwwwwwwwww"
        ]];
    }
    exit;
}

if(($comPos = strpos($message_text,"!md")) !== FALSE){
    $command = substr($message_text, $comPos + 3);
    $result = Generate_tex(trim($command), true);

    if($result){
        $img = file_get_contents(__DIR__."/../../result.png");
        $response_format_text = [returnImgurIds($img)];
    }else{
        $response_format_text = [[
            "type"=> "text",
            "text"=> "ふぇぇ...そんなMarkdownわかんないよお..."
        ]];
    }
    exit;
}