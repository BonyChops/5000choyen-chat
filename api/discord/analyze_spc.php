<?php
require_once(__DIR__.'/../../generate.php');
require_once(__DIR__.'/../imgur/upload.php');

$message_text =  $argv[1];
$comPos = 0;
if(($comPos = strpos($message_text,"!spc")) !== FALSE){
    if(!isset($roomType)){
        $userInfo = json_decode(getUserInfo($accesstoken, $userId), true);
    }else{
        if($roomType == "group"){
            $userInfo = json_decode(getGroupUserInfo($accesstoken, $userId, $RmId), true);
            file_put_contents(__DIR__."/../../docs/userIcon22.json",json_encode($userInfo));
        }
        if($roomType == "room"){
            $userInfo = json_decode(getRoomUserInfo($accesstoken, $userId, $RmId), true);
        }
        
    }
    $userName = $userInfo["displayName"];
    $iconURL = $userInfo["pictureUrl"];
    file_put_contents(__DIR__."/../../docs/userIcon.png",file_get_contents($iconURL));
    if(strpos($message_text,"/") !== FALSE){
        $command = substr($message_text, $comPos + 4);
        list($price,$comment) = explode('/',$command);
        Generate_SPC($price, $userName, $comment);
    }else{
        $command = substr($message_text, $comPos + 4);
        if(is_numeric($command)){
            Generate_SPC($command, $userName,"");
        }else{
            Generate_SPC(-1, $userName, trim($command));
        }
        
    }
    if (isset($json_object->{"events"}[0]->{"source"}->{"groupId"})) $userId =  $json_object->{"events"}[0]->{"source"}->{"groupId"};
    if (isset($json_object->{"events"}[0]->{"source"}->{"roomId"})) $userId =  $json_object->{"events"}[0]->{"source"}->{"roomId"};
    unlink(__DIR__."/../../docs/userIcon.png");
    exit;
}
