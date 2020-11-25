<?php
include "./function/htmlspchar.php";
session_start();

if (isset($_POST['test_id'])) {
    // echo('<pre>');
    // var_dump($_POST); // 確認用メッセージ
    // echo('</pre>');
    $test_id = $_POST['test_id'];
    // echo $test_id;
    if (isset($_POST['test_name'])) {
        include './db/connectDB.php';
        try {
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM `QuestionTable` WHERE test_ID=?');
            $stmt->bindValue(1, (int)$test_id, PDO::PARAM_INT);
            $stmt->execute();
            $cnt = $stmt->fetchColumn();
            var_dump($cnt); // 確認用
        } catch (PDOException $e) {
            print('Error:' . $e->getMessage());
            die();
        }
        $pdo = null;
        
        $_SESSION['ans'][0] = array(
            'test_id' => $test_id,
            'test_name' => $_POST['test_name']
        );
    }
    if (isset($_POST['Q_number'])) {
        $Q_number = $_POST['Q_number'];

        $_SESSION['ans'][$Q_number] = array(
            'number' => $Q_number,
            'ans' => $_POST['ans']
        );
    }
    $test_name = $_SESSION['ans'][0]['test_name'];
} else {
    header("Location: ./test_select.php");
}

// if (isset($_POST['ans'])) {
//     foreach ($_POST['ans'] as $answer) {
//         $sql = 'SELECT * FROM `Q_CheckBoxTable` WHERE ID=' . "$answer";
//         $statement = $pdo->query($sql);
//         $count = $statement->rowCount();
//         if ($count > 0) {
//             foreach ($statement as $value) {
//                 if ($value["is_correct_Ans"] == 1) {
//                     echo "正解<br>";
//                 } else {
//                     echo "不正解<br>";
//                 }
//             }
//         }
//     }
// }

if (isset($_POST['Q_number'])) {
    $Q_number = $_POST['Q_number'] + 1;
} else {
    $Q_number = 1;
}

include './db/connectDB.php';
$id = $test_id;
try {
    $stmt = $pdo->prepare('SELECT * FROM `QuestionTable` WHERE test_ID=? AND Q_number=?');
    $stmt->bindValue(1, (int)$id, PDO::PARAM_INT);
    $stmt->bindValue(2, (int)$Q_number, PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll();
    $Q_row = $rows[0];
    // $cnt = count($rows);
    // var_dump($cnt); // 確認用
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
}

try {
    $stmt = $pdo->prepare('SELECT * FROM `Q_CheckBoxTable` WHERE Q_ID=?');
    $stmt->bindValue(1, (int)$Q_row['ID'], PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll();
    $ch_row = $rows[0];
    // echo ('<pre>');  //
    // var_dump($rows); // 確認用
    // echo ('</pre>'); //
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
}

//データベース接続切断
$pdo = null;

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テスト回答ページ</title>
</head>

<body>
    <h2><?php echo hsc($test_name); ?></h2>
    <h3>問<?php echo hsc($Q_row['Q_number']); ?></h3>
    <p><?php echo hsc($Q_row['Q_text']); ?></p>

    <form action="test_ans.php" method="post">
        <?php
        foreach ($rows as $ch) {
            echo '<input type="checkbox" name="ans[]" value="' . hsc($ch['ID']) . '">';
            echo hsc($ch['checkbox_text']);
            echo "<br>";
        }
        ?>
        <input type="hidden" , name='test_id' , value=<?php echo hsc($id); ?>>
        <input type="hidden" , name='Q_number' , value=<?php echo hsc($Q_number); ?>>
        <input type="submit" value="回答">
    </form>

</body>

</html>