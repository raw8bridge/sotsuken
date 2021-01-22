<?php
session_start();

echo("<pre>");
var_dump($_SESSION);
echo("</pre>");
?>

<a href="./test/clrsec.php">SESSION[test]削除</a>
<br>
<a href="./test/Logout.php">ログアウト(SESSION完全削除)</a>