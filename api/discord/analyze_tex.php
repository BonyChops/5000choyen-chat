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

    if (isset($json_object->{"events"}[0]->{"source"}->{"groupId"})) $userId =  $json_object->{"events"}[0]->{"source"}->{"groupId"};
    if (isset($json_object->{"events"}[0]->{"source"}->{"roomId"})) $userId =  $json_object->{"events"}[0]->{"source"}->{"roomId"};
    $result = sending_messages($accesstoken, $replyToken, $response_format_text);
    file_put_contents(__DIR__."/../../docs/result1234.json",$result);
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

    $result = sending_messages($accesstoken, $replyToken, $response_format_text);
    file_put_contents(__DIR__."/../../docs/result1234.json",$result);
    exit;
}