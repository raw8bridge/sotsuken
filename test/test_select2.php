<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テスト選択画面</title>
</head>

<body>
    <h1>テスト選択画面</h1>
    <?php
    $dsn = 'mysql:host=localhost;dbname=OnlineTest;charset=utf8';
    $user = 'yuta';
    $password = 'dbpass';

    try {
        $pdo = new PDO($dsn, $user, $password);
        // sql
        $sql = 'SELECT `ID`, `test_name` FROM `TestTable`';
        $statement = $pdo->query($sql);

        // 取得したデータを出力
        // foreach ($statement as $value) {
        //     echo "$value[ID] $value[test_name] <br>";
        // }
        //データベース接続切断
        $pdo = null;
    } catch (PDOException $e) {
        print('Error:' . $e->getMessage());
        die();
    }

    $i = 0;
    foreach ($statement as $value){
    ?>
        <form method="post" name="form1" action="test_ans.php">
            <input type="hidden" name="test_id" value="<?php echo $value["ID"]; ?>">
            <input type="hidden" name="test_name" value="<?php echo $value["test_name"]; ?>">
            <input type="submit" value="<?php echo $value["test_name"]; ?>">
        </form>
    <?php $i++; } ?>
    
</body>

</html>