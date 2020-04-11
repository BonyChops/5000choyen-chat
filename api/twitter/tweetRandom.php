<?php
 
//インクルード
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__."/chooseTweet.php";
require_once __DIR__."/../../generate.php";
$sTwitterConsumerKey = $config['twitter']['key'];
$sTwitterConsumerSecret = $config['twitter']['secret'];
$sTwitterAccessToken = $config['twitter']['oauth']['key'];
$sTwitterAccessTokenSecret = $config['twitter']['oauth']['secret'];
//インポート
use Abraham\TwitterOAuth\TwitterOAuth;

$objTwitterConection = new TwitterOAuth
 (
 $sTwitterConsumerKey,
 $sTwitterConsumerSecret,
 $sTwitterAccessToken,
 $sTwitterAccessTokenSecret
 );

 $objTwitterConection2 = new TwitterOAuth
 (
 $sTwitterConsumerKey,
 $sTwitterConsumerSecret);


//$objTwUserInfo = $objTwitterConection->post("statuses/update",["status" => "Hello, world!"]);
if(!isset($argv[2])){
    $str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false);
    $str2 = chooseVerb($objTwitterConection,$objTwitterConection2,"",false);
    Generate($str, $str2."！");
}else{
    Generate($argv[1], $argv[2]);
}

$media1 = $objTwitterConection->upload('media/upload', ['media' => __DIR__."/../../result.png"]);
$objTwUserInfo = $objTwitterConection->post("statuses/update",["status" => '', 'media_ids' => implode(',', [$media1->media_id_string])]);
