<?php
function hsc($str) {
    return htmlspecialchars($str, ENT_QUOTES|ENT_HTML5, "UTF-8");
}
// HTMLに出力する際
// echo h('<hoge>');  
?>