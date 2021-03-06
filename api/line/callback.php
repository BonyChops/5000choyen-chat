<?php
require_once(__DIR__.'/../config.php');
$accesstoken = $config["line"]["accesstoken"];
require_once(__DIR__.'/../../generate.php');
require_once(__DIR__.'/../imgur/upload.php');
require_once(__DIR__.'/../../vendor/autoload.php');

 /*
//インポート
use Abraham\TwitterOAuth\TwitterOAuth;

$TwitterAccountInfo = json_decode(file_get_contents('login/'.$accesstoken_filename),true);

$objTwitterConection = new TwitterOAuth
 (
 $sTwitterConsumerKey,
 $sTwitterConsumerSecret,
 $TwitterAccountInfo['twAccessToken']['oauth_token'],
 $TwitterAccountInfo['twAccessToken']['oauth_token_secret']
 );

 $objTwitterConection2 = new TwitterOAuth
 (
 $sTwitterConsumerKey,
 $sTwitterConsumerSecret);
 */
//ユーザーからのメッセージ取得
chdir(__DIR__);
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
file_put_contents("rec_debug.json",$json_string);
//取得データ
$replyToken = $json_object->{"events"}[0]->{"replyToken"};        //返信用トークン
$userId =  $json_object->{"events"}[0]->{"source"}->{"userId"};
$sourceType =  $json_object->{"events"}[0]->{"source"}->{"type"};
if (isset($json_object->{"events"}[0]->{"source"}->{"groupId"})){
    $RmId =  $json_object->{"events"}[0]->{"source"}->{"groupId"};
    $roomType = "group";
}
if (isset($json_object->{"events"}[0]->{"source"}->{"roomId"})){
    $RmId =  $json_object->{"events"}[0]->{"source"}->{"roomId"};
    $roomType = "room";
}
$sendType = $json_object->{"events"}[0]->{"type"};
$message_type = $json_object->{"events"}[0]->{"message"}->{"type"};    //メッセージタイプ
if ($message_type == "text"){
    $message_text = $json_object->{"events"}[0]->{"message"}->{"text"};    //メッセージ内容
}
$recieve_data = $json_object->{"events"}[0]->{"postback"}->{"data"};
if(file_exists(__DIR__."/../../result.png")){
    unlink(__DIR__."/../../result.png");
}


$comPos = 0;
if(($comPos = strpos($message_text,"!5cho")) !== FALSE){
    if(strpos($message_text,"/") !== FALSE){
        //$str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false);
        $command = substr($message_text, $comPos + 5);
        list($top,$bottom) = explode('/',$command);
        echo "Generating...";
        $test = Generate(trim($top), trim($bottom));
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
    }
    $img = file_get_contents(__DIR__."/../../result.png");
    $imgResult =  uploadImgur(base64_encode($img));
    $imgId = $imgResult['data']['id'];
    $response_format_text = [[
        "type"=> "image",
        "originalContentUrl"=> "https://i.imgur.com/".$imgId.".png",
        "previewImageUrl"=> "https://i.imgur.com/".$imgId."l.png"
    ]];
    if (isset($json_object->{"events"}[0]->{"source"}->{"groupId"})) $userId =  $json_object->{"events"}[0]->{"source"}->{"groupId"};
    if (isset($json_object->{"events"}[0]->{"source"}->{"roomId"})) $userId =  $json_object->{"events"}[0]->{"source"}->{"roomId"};
    $result = sending_messages($accesstoken, $replyToken, $response_format_text);
    unlink(__DIR__."/../../result.png");
    exit;
}

if(($comPos = strpos($message_text,"!spc2")) !== FALSE){
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
        $command = substr($message_text, $comPos + 5);
        list($price,$comment) = explode('/',$command);
        Generate_SPC($price, $userName, $comment);
    }else{
        $command = substr($message_text, $comPos + 5);
        if(is_numeric($command)){
            Generate_SPC($command, $userName,"");
        }else{
            Generate_SPC(-1, $userName, trim($command));
        }

    }
    $img = file_get_contents(__DIR__."/../../result.png");
    $response_format_text = [returnImgurIds($img)];
    if (isset($json_object->{"events"}[0]->{"source"}->{"groupId"})) $userId =  $json_object->{"events"}[0]->{"source"}->{"groupId"};
    if (isset($json_object->{"events"}[0]->{"source"}->{"roomId"})) $userId =  $json_object->{"events"}[0]->{"source"}->{"roomId"};
    $result = sending_messages($accesstoken, $replyToken, $response_format_text);
    unlink(__DIR__."/../../docs/userIcon.png");
    unlink(__DIR__."/../../result.png");
    exit;
}

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
    if(strpos($message_text,"/") !== FALSE){
        $command = substr($message_text, $comPos + 4);
        list($price,$comment) = explode('/',$command);
        $response_format_text = Generate_SPC_flex($price, $userName, $comment, $iconURL);
    }else{
        $command = substr($message_text, $comPos + 4);
        if(is_numeric($command)){
            $response_format_text = Generate_SPC_flex($command, $userName,"", $iconURL);
        }else{
            $response_format_text = Generate_SPC_flex(-1, $userName, trim($command), $iconURL);
        }
    }
    if (isset($json_object->{"events"}[0]->{"source"}->{"groupId"})) $userId =  $json_object->{"events"}[0]->{"source"}->{"groupId"};
    if (isset($json_object->{"events"}[0]->{"source"}->{"roomId"})) $userId =  $json_object->{"events"}[0]->{"source"}->{"roomId"};
    $result = sending_messages($accesstoken, $replyToken, $response_format_text);
    file_put_contents(__DIR__."/../../docs/result1234.json",$result);
    exit;
}

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


if(($comPos = strpos($message_text,"!gnuplot")) !== FALSE){
    if(strpos($message_text, "-img")){
        $sendLink = true;
        $comPos += 4;
    }else{
        $sendLink =false;
    }
    if(strpos($message_text,"!gnuplot-r") !== FALSE){
        $command = substr($message_text, $comPos + 8 + 2);
        $sameRate = true;
    }else{
        $command = substr($message_text, $comPos + 8);
        $sameRate = false;
    }

    $result = Generate_gnuplot(trim($command), $sameRate);

    if($result){
        $img = file_get_contents(__DIR__."/../../result-gnuplot.png");
        if(!$sendLink){
            $response_format_text = [returnImgurIds($img)];
        }else{
            $response_format_text = [[
                "type" => "text",
                "text" => returnImgurIds($img)["originalContentUrl"]
            ]];
        }
    }else{
        $response_format_text = [[
            "type"=> "text",
            "text"=> "gnuplot「...」\n(へんじがない、ただのしかばねのようだ)"
        ]];
    }
    $result = sending_messages($accesstoken, $replyToken, $response_format_text);
    file_put_contents(__DIR__."/../../docs/result1234.json",$result);
    exit;
}

if(($comPos = strpos($message_text,"!avicii")) !== FALSE){

    $response_format_text = [[
        "type"=> "flex",
        "altText"=> "◢ ◤ Avicii",
        "contents"=>avicii('https://bonychops.com/experiment/5000choyen-chat/randomAvicii.php')
    ]];
    $result = sending_messages($accesstoken, $replyToken, $response_format_text);
}

if((($sourceType != "group")&&($sourceType != "room"))){
    if($sendType == "join"){
        $response_format_text = [[
            "type" => "text",
            "text" => "5000兆円ほしい！！！\nコマンドは以下"
        ],[
            "type" => "text",
            "text" => "!5cho 5000兆円/欲しい！"
        ],[
            "type" => "text",
            "text" => "!spc 金額/(メッセージ)"
        ]];
        $result = sending_messages($accesstoken, $replyToken, $response_format_text);
        exit;
    }
}

if((strpos($message_text,"/unchi") !== FALSE)){
    $response_format_text = [[
        "type" => "video",
        "originalContentUrl" => "https://bonychops.com/experiment/Happinessbot/LINE/OtowareShimaziro.mp4",
        "previewImageUrl" => "https://kotonova.com/wp-content/uploads/2016/05/ecb4746a9a9e9ca11f60f6e1fcdc3d76-768x432.png"
    ]];
    $result = sending_messages($accesstoken, $replyToken, $response_format_text);
    exit;
}

if(($sourceType == "group")||($sourceType == "room")){
    if($sendType == "join"){
        $response_format_text = [[
            "type" => "text",
            "text" => "5000兆円ほしい！！！\nコマンドは以下"
        ],[
            "type" => "text",
            "text" => "!5cho 5000兆円/欲しい！"
        ],[
            "type" => "text",
            "text" => "!spc 金額/(メッセージ)"
        ]];
        $result = sending_messages($accesstoken, $replyToken, $response_format_text);
        exit;
    }
}


//どれにも該当しない場合

function returnImgurIds($img){
    $imgResult =  uploadImgur(base64_encode($img));
    $imgId = $imgResult['data']['id'];
    return [
        "type"=> "image",
        "originalContentUrl"=> "https://i.imgur.com/".$imgId.".png",
        "previewImageUrl"=> "https://i.imgur.com/".$imgId."l.png"
    ];
}

//echo $result;
function sending_messages($accessToken, $replyToken, $response_format_text){
    //レスポンスフォーマット


    //ポストデータ
    $post_data = [
        "replyToken" => $replyToken,
        "messages" => $response_format_text
    ];

    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function pushing_messages($accessToken, $userId, $response_format_text){
    //レスポンスフォーマット


    //ポストデータ
    $post_data = [
        "to" => $userId,
        "messages" => $response_format_text
    ];

    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/message/push");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function getUserInfo($accessToken, $userId){

    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/profile/".$userId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function getGroupUserInfo($accessToken, $userId, $RmId){

    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/group/".$RmId."/member/".$userId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function getRoomUserInfo($accessToken, $userId, $RmId){

    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/room/".$RmId."/member/".$userId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function getUserIcon($url){

    //curl実行
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8'
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}