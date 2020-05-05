
<?php
function chooseTweet($objTwitterConection, $objTwitterConection2,$custom = "", $like = false, $displayMessage = true){
    //srand(time());

    $date = date('Y-m-d G:i:s');
    $words = json_decode(file_get_contents(__DIR__."/../../words/words.json",true));
    if(($words == array())||(!isset($words))){
        $words = [
            "bonychops"
        ];
    }

    shuffle($words);
    $cntWord = $words[rand(0,sizeof($words)-1)];
    if($custom != ""){
        $cntWord = $custom;
    }

    if($displayMessage == true){
        printf($cntWord."\n");
    }

    if(!isset($LastID)){
        $searchResult = $objTwitterConection2->get("search/tweets",["q" => $cntWord, "count" => 100,"lang" => "ja"]);
    }else{
        //printf("LastID detected:".$LastID."\n");
        $searchResult = $objTwitterConection2->get("search/tweets",["q" => $cntWord, "count" => 100,"lang" => "ja","max_id"=>$LastID]);
    }
    foreach($searchResult->{"statuses"} as $value){
        $str = $value->{"text"};
        $str = processTweet($str);
        exec('echo \''.$str.'\' | mecab',$array);
        foreach($array as $value2){
            if($value2 != 'EOS'){
                list($s,$s2) = sscanf($value2,"%s %s");

                list($type,$dump,$dump,$dump,$dump,$dump,$default,$dump,$dump) = explode(",", $s2);

                if($type == "名詞"){
                    printf($default."\n");
                    if(
                        (array_search($default,$words) === false)
                    ){
                        array_push($words,$default);
                    }
                }
            }
        }
    }
    //var_dump($searchResult->{"statuses"}[0]);
    file_put_contents(__DIR__."/../../words/words.json",json_encode($words));
    return $cntWord;
}

function chooseVerb($objTwitterConection, $objTwitterConection2,$custom = "", $like = false, $displayMessage = true){
    //srand(time());

    $date = date('Y-m-d G:i:s');
    $words = json_decode(file_get_contents(__DIR__."/../../words/verb.json",true));
    if(($words == array())||(!isset($words))){
        $words = [
            "欲しい"
        ];
    }

    shuffle($words);
    $cntWord = $words[rand(0,sizeof($words)-1)];
    if($custom != ""){
        $cntWord = $custom;
    }

    if($displayMessage == true){
        printf($cntWord."\n");
    }
    if(!isset($LastID)){
        $searchResult = $objTwitterConection2->get("search/tweets",["q" => $cntWord, "count" => 100,"lang" => "ja"]);
    }else{
        //printf("LastID detected:".$LastID."\n");
        $searchResult = $objTwitterConection2->get("search/tweets",["q" => $cntWord, "count" => 100,"lang" => "ja","max_id"=>$LastID]);
    }
    foreach($searchResult->{"statuses"} as $value){
        $str = $value->{"text"};
        $str = processTweet($str);
        exec('echo \''.$str.'\' | mecab',$array);
        foreach($array as $value2){
            if($value2 != 'EOS'){
                list($s,$s2) = sscanf($value2,"%s %s");

                list($type,$dump,$dump,$dump,$dump,$dump,$default,$dump,$dump) = explode(",", $s2);

                if($type == "動詞"){
                    printf($default."\n");
                    if(
                        (array_search($default,$words) === false)
                    ){
                        array_push($words,$default);
                    }
                }
            }
        }
    }
    //var_dump($searchResult->{"statuses"}[0]);
    file_put_contents(__DIR__."/../../words/verb.json",json_encode($words));
    return $cntWord;

}

//From https://qiita.com/nobuyuki-ishii/items/2838e663e2ab8d99ffd5
function processTweet($text) {
    $text = deleteUser($text);
    $text = deleteNewLine($text);
    $text = deleteUrl($text);
    //$text = deleteHashtag($text);
    $text = deleteNonUtf8($text);
    $text = convertHtmlSpecialCharcter($text);
    return $text;
  }
  // ユーザ名（@～）を消す
  function deleteUser($text) {
    return preg_replace('/@.*\s/', '', $text);
  }

  // 改行をスペースに変換
  function deleteNewLine($text) {
    return str_replace(array("\r\n", "\r", "\n"), ' ', $text);
  }

  // http引用を消す
  function deleteUrl($text) {
    return preg_replace('/(https?)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/', '', $text);
  }

  // ハッシュタグ（#～）を消す
  function deleteHashtag($text) {
    return preg_replace('/#.*/', '', $text);
  }

  // 変換不能文字を消す
  function deleteNonUtf8($text) {
    //reject overly long 2 byte sequences, as well as characters above U+10000 and replace with ?
    $text = preg_replace(
      '/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
      '|[\x00-\x7F][\x80-\xBF]+'.
      '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
      '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
      '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
      '', $text );

    //reject overly long 3 byte sequences and UTF-16 surrogates and replace with ?
    $text = preg_replace(
      '/\xE0[\x80-\x9F][\x80-\xBF]'.
      '|\xED[\xA0-\xBF][\x80-\xBF]/S',
      '', $text );

    return $text;
  }

  // html特殊文字を変換する
  function convertHtmlSpecialCharcter($text) {
    return htmlspecialchars_decode($text);
  }