<?php
include "./function/htmlspchar.php";
session_start();

if (isset($_POST['Q_number'])) {
    $Q_number = $_POST['Q_number'];

    $_SESSION['test'][$Q_number] = array(
        'number' => $Q_number,
        'text' => $_POST['main_text'],
        'checkbox_text' => $_POST['checkbox_text'],
        'is_correct' => $_POST['is_correct']
    );

    // echo('<pre>');
    // var_dump($_SESSION['test']); // 確認用メッセージ
    // echo('</pre>');
    $Q_number++;
} else {
    $Q_number = 1;
}

if (isset($_POST['next'])) {
    // echo "next"; // テストメッセージ
} elseif (isset($_POST['create'])) {
    $_SESSION['test']['iscreate'] = true;

    header("Location: ./test_view2.php");
    exit();
}

if (isset($_POST['test_name']) and isset($_POST['subject_id'])) {
    $test_name = $_POST['test_name'];
    $subject_id = $_POST['subject_id'];
    $creater_id = 1; // 作成者ID、ダミー
    $_SESSION['test'][0] = array(
        'test_name' => $test_name,
        'creater_id' => $creater_id,
        'subject_id' => $subject_id
    );
}

$storage = array();
if (isset($_POST['storage'])) {
    $storage = $_POST['storage'];
    print_r($storage);
}

$test_id = 1; // ダミー
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>フォーム送信テストページ</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="./test_script2.js"></script>
    <!-- Bootstrap CSS -->
    <!--
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> -->
</head>

<body>
    <?php
    // $dsn = 'mysql:host=localhost;dbname=OnlineTest;charset=utf8';
    // $user = 'yuta';
    // $password = 'dbpass';

    // try {
    //     $pdo = new PDO($dsn, $user, $password);
    //     // echo "接続成功";
    //     // sql
    //     $sql = 'INSERT INTO TestTable (subject_ID, creater_ID, test_name) VALUES (1, 1, "' . $_POST['test_name'] . '")';
    //     $statement = $pdo->query($sql);
    //     // 登録したデータのIDを取得
    //     $test_id = $pdo->lastInsertId();

    //     //データベース接続切断
    //     $pdo = null;
    // } catch (PDOException $e) {
    //     print('Error:' . $e->getMessage());
    //     die();
    // }
    ?>

    <h2><?php echo hsc($test_name); ?></h2>
    <h3>問<?php echo hsc($Q_number); ?></h3>

    <form action="" method="post">
        <h4>テキスト</h4>
        <textarea name="main_text" rows="8" cols="50" class="main_text_form"></textarea>

        <h4>選択肢</h4>
        <div>1</div>
        <input type="checkbox" id="checkbox1" name="is_correct[]" value="0" class="is_correct_form">
        <input type="text" name="checkbox_text[]" value="" class="checkbox_text_form">
        <div class="box" data-formno="0">
            <div id="input_pluralBox">
                <div id="input_plural">
                    <div class="no">2</div>
                    <input type="checkbox" id="checkbox1" name="is_correct[]" value="1" class="is_correct_form">
                    <input type="text" name="checkbox_text[]" value="" class="checkbox_text_form">
                    <input type="button" value="－" class="deletformbox">
                    <input type="button" value="＋" class="addformbox">
                </div>
            </div>
        </div>
        <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
        <input type="hidden" name="Q_number" value="<?php echo $Q_number; ?>">
        <input type="hidden" name="sotrage" value="<?php echo $storage; ?>">
        <div>
            <input type="submit" name="next" value="次へ">
            <input type="submit" name="create" value="テスト作成">
        </div>
    </form>
</body>

</html>