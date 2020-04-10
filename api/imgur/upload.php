<?php
$img = file_get_contents("../../result.png");
uploadImgur(base64_encode($img));

function uploadImgur($imgdata){
    echo "a";
    $client_id = 'b59a4f70000e154';
    $pvars   = array('image' => $imgdata, 'key' => $client_id);
    $timeout = 30;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image');
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
    $out = curl_exec($curl);
    curl_close ($curl);
    echo $out;
    return $out;
}
