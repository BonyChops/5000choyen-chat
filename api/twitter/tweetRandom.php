<?php
 
//インクルード
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../../vendor/autoload.php';
require_once __DIR__."/chooseTweet.php";
$sTwitterConsumerKey = $config['twitter']['key'];
$sTwitterConsumerSecret = $config['twitter']['secret'];
$sTwitterAccessToken = $config['twitter']['oauth']['key'];
$sTwitterAccessTokenSecret = $config['twitter']['oauth']['secret'];
//インポート
use Abraham\TwitterOAuth\TwitterOAuth;

$TwitterAccountInfo = json_decode(file_get_contents('login/'.$accesstoken_filename),true);

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

$str = chooseTweet($objTwitterConection,$objTwitterConection2,"",false);
$objTwUserInfo = $objTwitterConection->post("statuses/update",["status" => $str]);
if($statuses == ""){
    $statuses = array();
}
