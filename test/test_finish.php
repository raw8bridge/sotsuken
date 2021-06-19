<?php
include "./function/htmlspchar.php";
session_start();

$test_name = $_SESSION['ans'][0]['test_name'];
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>解答完了ページ</title>
</head>

<body>
<h2>解答完了</h2>
<p><?php echo(hsc($test_name)); ?>の解答を送信しました。</p>
<a href="Main_student.php">メイン画面に戻る</a>
</body>

</html>