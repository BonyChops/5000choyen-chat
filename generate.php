<?php
function Generate($str1, $str2){
    echo sprintf("node %s/docs/main.js %s %s",__DIR__ ,$str1, $str2);
    exec(sprintf("node %s/docs/main.js %s %s",__DIR__ ,$str1, $str2));
}
?>