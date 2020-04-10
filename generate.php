<?php
function Generate($str1, $str2){
    sprintf('node %s/docs/main.js "%s" "%s"',__DIR__ ,$str1, $str2);
    return exec(sprintf('node %s/docs/main.js "%s" "%s"',__DIR__ ,$str1, $str2));
}
?>