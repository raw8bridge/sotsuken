<?php
include "./function/htmlspchar.php";
include "./db/connectDB.php";

session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
if (!($_SESSION["ROLE"] == '1')) {
    header("Location: Main_student.php");
    exit;
}

$teacher_id = $_SESSION['ID']; // 教員ID

try {
    // sql
    $stmt = $pdo->prepare('SELECT * FROM `SubjectTable` WHERE `teacher_ID`= ?');
    $stmt->bindValue(1, (int)$teacher_id, PDO::PARAM_INT);
    $stmt->execute();
    //データベース接続切断
    $pdo = null;
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
}
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows); // 確認用
$rows_cnt = count($rows); // 件数
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>課題作成ページ</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <!--
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->
</head>
<body>
    <h2>課題作成</h2>
    <form action="test_create_Q.php" method="post">
        <p>科目名</p>
        <select name="subject_id">
        <?php
        foreach($rows as $row) {
            echo '<option value=' . hsc($row['ID']) . '>' . hsc($row['name']) . '</option>';
        }
        ?>
        </select>
        
        <p>課題名</p>
        <input type="text" name="test_name" value="" class="test_name_form">
        <input type="submit" value="作成">
    </form>
</body>

</html>