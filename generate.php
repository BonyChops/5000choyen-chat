<?php
function Generate($str1, $str2){
    exec(sscanf("node %s/docs/main.js %s %s",__DIR__ ,$str1, $str2));
}
?>