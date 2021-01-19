<?php
include './DBLogin2.php';
$login = new DBLogin();

// セッション開始
session_start();

$db['host'] = $login->host;  // DBサーバのURL
$db['user'] = $login->user;  // ユーザー名
$db['pass'] = $login->pass;  // ユーザー名のパスワード
$db['dbname'] = $login->dbname;  // データベース名
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', $db['host'], $db['dbname']);

// メッセージの初期化
$msg = "";
try {
    // データベースに接続
    $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    if (isset($_POST['add'])) {
        if (empty($_POST['text'])) {
            $msg = '内容が未入力です';
        } else if (empty($_POST['want_per'])) {
            $msg = 'やりたい度が未入力です';
        }

        if (!empty($_POST['text']) && !empty($_POST['want_per'])) {
            $text = $_POST['text'];
            $want_per = $_POST['want_per'];
            $date = $_POST['date'];
            $date_op = $_POST['date_op'];
            if (empty($_POST['date'])) {
                $date_op = null;
            }
            // var_dump(array($text, $want_per, $date, $date_op)); // 確認用
            $sql = 'INSERT INTO task(text, want_per, date, date_op) VALUE(?, ?, ?, ?)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array($text, $want_per, $date, $date_op));
            $msg = '追加しました';
        }
    }
    if (isset($_POST['delid'])) {
        $sql = 'DELETE FROM task WHERE ID = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($_POST['delid']));
        $msg = '削除しました';
        // var_dump($stmt);
    }

    $sql = 'SELECT * FROM `task`';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($rows); // 確認用

} catch (PDOException $e) {
    $msg = 'データベースエラー';
    //$errorMessage = $sql;
    // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>やりたいことリスト</title>
</head>

<body>
    <h1>やりたいことリスト</h1>
    <div class="msg"><?php echo (htmlspecialchars($msg, ENT_QUOTES | ENT_HTML5, "UTF-8")); ?></div>
    <table>
        <tr>
            <th>やりたいこと</th>
            <th>やりたい度[%]</th>
            <th>日にち</th>
        </tr>
        <?php foreach ($rows as $row) { ?>
            <tr>
                <td><?php echo (htmlspecialchars($row['text'], ENT_QUOTES | ENT_HTML5, "UTF-8")); ?></td>
                <td><?php echo (htmlspecialchars($row['want_per'], ENT_QUOTES | ENT_HTML5, "UTF-8")); ?></td>
                <td><?php echo (htmlspecialchars($row['date'], ENT_QUOTES | ENT_HTML5, "UTF-8"));
                    echo (htmlspecialchars($row['date_op'], ENT_QUOTES | ENT_HTML5, "UTF-8")); ?></td>
                <td><button class="delete" id=<?php echo (htmlspecialchars($row['ID'], ENT_QUOTES | ENT_HTML5, "UTF-8")) ?>>削除</button></td>
            </tr>
        <?php } ?>
    </table>
    <h2>追加</h2>
    <form action="#" method="POST">
        <p>内容</p>
        <textarea name="text"></textarea>
        <br>
        <p>やりたい度</p>
        <input type="number" name="want_per">
        <br>
        <p>日付</p>
        <input type="date" name="date">
        <input type="radio" id="date_op" name="date_op" value="まで" checked="checked">まで
        <input type="radio" id="date_op" name="date_op" value="あたり">あたり
        <input type="submit" id="add" name="add" value="追加">
    </form>
    <form id="delform" action="#" method="POST">
        <input type="hidden" id="delid" name="delid">
    </form>
    <script src="./delete.js"></script>
</body>

</html>