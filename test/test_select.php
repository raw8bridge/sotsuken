<?php
include "./function/htmlspchar.php";
include "./db/connectDB.php";

session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
if (!($_SESSION["ROLE"] == '2')) {
    header("Location: Main_student.php");
    exit;
}

$class_id = $_SESSION['CLASS_ID']; // テスト用

try {
    // sql 1
    $sql = 'SELECT subject_ID, SubjectTable.name FROM `Classes_Subject` INNER JOIN `SubjectTable` ON (Classes_Subject.subject_ID = SubjectTable.ID) AND Classes_Subject.class_ID= ?';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, (int)$class_id, PDO::PARAM_INT);
    $stmt->execute();
    // 科目ID、科目名取得
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_UNIQUE);

    // sql 2
    // IN 句に入る値を作成
    $inClause = substr(str_repeat(',?', count($subjects)), 1); // '?,?,?,...'
    $sql = "SELECT `subject_ID`, `ID`, `test_name` FROM `TestTable` WHERE `subject_ID` IN ({$inClause})";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_keys($subjects));

    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC | PDO::FETCH_GROUP);

    //データベース接続切断
    $pdo = null;
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
}

// print_r($subjects); // 確認用
// print_r($tests); // 確認用
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>課題選択ページ</title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style/select.css">
    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>テスト選択画面</title>
    </head>

<body>
    <h1>テスト選択画面</h1>
    <p>ユーザ名:<?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?><br>
    所属　　:<?php echo htmlspecialchars($_SESSION["CLASS_NAME"], ENT_QUOTES); ?></p>
    <ul>

    <?php foreach ($subjects as $sub_id => $sub_name) { ?>
        <h2><?php echo (hsc($sub_name['name'])); ?></h2>
        <ul>
            <?php foreach ($tests[$sub_id] as $test) { ?>
                <li>
                    <form method="post" action="test_ans.php">
                        <input type="hidden" name="test_id" value="<?php echo (hsc($test["ID"])); ?>">
                        <input type="hidden" name="test_name" value="<?php echo (hsc($test["test_name"])); ?>">
                        <input type="hidden" name="status" value="start">
                        <input type="submit" class="link_button" value="<?php echo (hsc($test["test_name"])); ?>">
                    </form>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</body>

</html>