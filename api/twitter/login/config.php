<?php
/*---------------[重要！！]------------------------------------
このconfig_sample.phpをconfig.phpへ名前を変更しないと動作しません！
---------------------------------------------------------------
*/
//アプリケーションの Consumer Key と Consumer Secret
$sTwitterConsumerKey = '***********************************'; //Consumer Key (API Key)
$sTwitterConsumerSecret = 'A0uH2GVZFe2DDBJImR0BcfS5c1mQBX0NYRt62KDDmlPU1QpzGc'; //Consumer Secret (API Secret)
 
//アプリケーションのコールバックURL
$sTwitterCallBackUri = 'https://bonychops.com/experiment/Happinessbot/callback.php'; //コールバックURL

//アクセストークンを保存するファイル名(変更推奨)
$accesstoken_filename = "accesstoken.js";
 
//変数初期化
$objTwitterConection = NULL; //TwitterOAuthクラスのインスタンス化
$aTwitterRequestToken = array(); //リクエストトークン
$sTwitterRequestUrl = ''; //認証用URL
$objTwitterAccessToken = NULL; //アクセストークン
$objTwUserInfo = NULL; //ユーザー情報
?>

