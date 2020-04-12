<?php
require_once(__DIR__.'/../../generate.php');
require_once(__DIR__.'/../imgur/upload.php');

$message_text =  $argv[1];
$comPos = 0;
if(($comPos = strpos($message_text,"!5cho")) !== FALSE){
    if(strpos($message_text,"/") !== FALSE){
        //$str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false);
        $command = substr($message_text, $comPos + 5);
        list($top,$bottom) = explode('/',$command);
        echo "Generating...";
        $test = Generate(trim($top), trim($bottom));
        $img = file_get_contents(__DIR__."/../../result.png");
        $imgResult =  uploadImgur(base64_encode($img));
        $imgId = $imgResult['data']['id'];
        $response_format_text = [[
            "type"=> "image",
            "originalContentUrl"=> "https://i.imgur.com/".$imgId.".png",
            "previewImageUrl"=> "https://i.imgur.com/".$imgId."m.png"
        ]];
        print("https://i.imgur.com/".$imgId.".png");
        file_put_contents(__DIR__."/imgur_url.json",json_encode(['url' =>"https://i.imgur.com/".$imgId.".png"]));
        exit;
    }else{
        $words = json_decode(file_get_contents(__DIR__."/../../words/words.json",true));
        $verbs = json_decode(file_get_contents(__DIR__."/../../words/verb.json",true));
        if(($words == array())||(!isset($words))){
            $words = [
                "5000兆円"
            ];
        }
        if(($verbs == array())||(!isset($verbs))){
            $verbs = [
                "欲しい"
            ];
        }
        shuffle($words);
        $top = $words[rand(0,sizeof($words)-1)];
        shuffle($verbs);
        $bottom = $verbs[rand(0,sizeof($verbs)-1)];
        echo "Generating...";
        $test = Generate(trim($top), trim($bottom)."！");
        $img = file_get_contents(__DIR__."/../../result.png");
        $imgResult =  uploadImgur(base64_encode($img));
        $imgId = $imgResult['data']['id'];
        $response_format_text = [[
            "type"=> "image",
            "originalContentUrl"=> "https://i.imgur.com/".$imgId.".png",
            "previewImageUrl"=> "https://i.imgur.com/".$imgId."m.png"
        ]];
        print("https://i.imgur.com/".$imgId.".png");
        file_put_contents(__DIR__."/imgur_url.json",json_encode(['url' =>"https://i.imgur.com/".$imgId.".png"]));
        exit;
    }

}
