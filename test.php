<?php
if ( exec('echo a',$array)) {
  //command失敗を検知して処理したい
  echo "OK";
}else{
  echo "NG";
}