<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
if (!($_SESSION["ROLE"] == '2')) {
    header("Location: Main_teacher.php");
    exit;
}
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>メイン</title>
</head>

<body>
    <h1>メイン画面（学生）</h1>
    <p>ユーザ名:<?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?><br>
    所属　　:<?php echo htmlspecialchars($_SESSION["CLASS_NAME"], ENT_QUOTES); ?></p>
    <ul>
        <li><a href="test_create_test.php">課題を選択</a></li>
        <li><a href="Logout.php">ログアウト</a></li>
    </ul>
</body>

</html>