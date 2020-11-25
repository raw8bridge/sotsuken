<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php
  define('MAX', 8);
  $dsn = 'mysql:host=localhost;dbname=OnlineTest;charset=utf8';
  $user = 'yuta';
  $password = 'dbpass';

  try {
    $pdo = new PDO($dsn, $user, $password);
    echo "接続成功<br>";
    $main = $_POST['main_text'];
    $test_id = $_POST['test_id'];

    $sql = 'INSERT INTO QuestionTable (test_ID, Q_number, Q_text) VALUES ('.$test_id.', 1, "' . $main . '")';
    $statement = $pdo->query($sql);
    // IDを取得
    $Q_ID = $pdo->lastInsertId();



    for ($i = 0; $i < MAX; $i++) {
      if ($_POST['checkbox_text_' . $i] != "") {
        $text[$i] = $_POST['checkbox_text_' . $i];
        $is_correct = 0;

        if (!empty($_POST['is_correct'])) {
          foreach ($_POST['is_correct'] as $correct) {
            if ($correct == $i) {
              echo $i . $text[$i] . "<br>";
              $is_correct = 1;
            }
          }
        }
        // sql
        $sql = 'INSERT INTO Q_CheckBoxTable (Q_ID, checkbox_text, is_correct_Ans) VALUES (' . $Q_ID . ',"' . $text[$i] . '",' . $is_correct . ')';
        $statement = $pdo->query($sql);
      }
    }

    //データベース接続切断
    $pdo = null;
  } catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
  }
  ?>
</body>

</html>