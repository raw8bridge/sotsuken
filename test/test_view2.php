<?php
include "./function/htmlspchar.php";
include "./db/connectDB.php";
session_start();

if (isset($_SESSION['test']['iscreate'])) {
  if (isset($_SESSION['test'])) {
    echo ('<pre>');
    var_dump($_SESSION['test']); // 確認用メッセージ
    echo ('</pre>');
    $test = $_SESSION['test'];
    if (isset($test[0])) {
      if (isset($test[0]['subject_id'])) {
        $subject_id = $test[0]['subject_id'];
      } else {
        echo '$test[0]["subject_id"] is not set.';
      }
      if (isset($test[0]['creater_id'])) {
        $creater_id = $test[0]['creater_id'];
      } else {
        echo '$test[0]["creater_id"] is not set.';
      }
      if (isset($test[0]['test_name'])) {
        $test_name = $test[0]['test_name'];
      } else {
        echo '$test[0]["test_name"] is not set.';
      }
    } else {
      echo '$test[0] is not set.';
    }
  }
} else {
  echo "error";
  exit();
}
$_SESSION['test']['iscreate'] = false;

if (!empty($subject_id) && !empty($creater_id) && !empty($test_name)) {
  try {
    $stmt = $pdo->prepare('INSERT INTO TestTable (subject_ID, creater_ID, test_name) VALUES (?, ?, ?);');
    $stmt->bindValue(1, (int)$subject_id, PDO::PARAM_INT);
    $stmt->bindValue(2, (int)$creater_id, PDO::PARAM_INT);
    $stmt->bindValue(3, $test_name);
    $stmt->execute();
    // var_dump($pdo->lastInsertId());
    $test_id = $pdo->lastInsertId(); // テストIDを取得
  } catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
  }

  foreach ($test as $t) {
    if (isset($t['number']) and isset($t['text'])) {
      $Q_number = $t['number'];
      $Q_text = $t['text'];
      try {
        $sql = 'INSERT INTO QuestionTable (test_ID, Q_number, Q_text, is_code, is_flowchart) VALUES (?, ?, ?, ?, ?);';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, (int)$test_id, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$Q_number, PDO::PARAM_INT);
        $stmt->bindValue(3, $Q_text);
        $stmt->bindValue(5, $_SESSION['test'][$Q_number]['use_editor']);
        $stmt->bindValue(4, $_SESSION['test'][$Q_number]['use_flowchart'] + 0);
        $stmt->execute();
        $Q_id = $pdo->lastInsertId(); // 設問ID
      } catch (PDOException $e) {
        print('Error:' . $e->getMessage());
        die();
      }

      if (!empty($t['img']['name'])) {
        $img = $t['img'];
        try {
          $sql = 'INSERT INTO Flowchart (Q_ID, fc_name, img_type, fc_content, img_size) VALUES (?, ?, ?, ?, ?);';
          $stmt = $pdo->prepare($sql);
          $stmt->bindValue(1, (int)$Q_id, PDO::PARAM_INT);
          $stmt->bindValue(2, $img['name'], PDO::PARAM_STR);
          $stmt->bindValue(3, $img['type'], PDO::PARAM_STR);
          $stmt->bindValue(4, $img['content'], PDO::PARAM_STR);
          $stmt->bindValue(5, (int)$img['size'], PDO::PARAM_INT);
          $stmt->execute();
        } catch (PDOException $e) {
          print('Error:' . $e->getMessage());
          die();
        }
      }

      if (!empty($t['editor_text'])) {
        try {
          $sql = 'INSERT INTO Q_Code (Q_ID, P_language_ID, code) VALUES (?, ?, ?);';
          $stmt = $pdo->prepare($sql);
          $stmt->bindValue(1, (int)$Q_id, PDO::PARAM_INT);
          $stmt->bindValue(2, (int)1, PDO::PARAM_INT);
          $stmt->bindValue(3, $t['editor_text'], PDO::PARAM_STR);
          $stmt->execute();
        } catch (PDOException $e) {
          print('Error:' . $e->getMessage());
          die();
        }
      }

      $cnt = 0;
      foreach ($t['checkbox_text'] as $ch) {
        if (in_array($cnt, $t['is_correct'])) {
          $is_correct = 1;
        } else {
          $is_correct = 0;
        }
        try {
          $stmt = $pdo->prepare('INSERT INTO Q_CheckBoxTable (Q_ID, checkbox_text, is_correct_Ans) VALUES (?, ?, ?);');
          $stmt->bindValue(1, (int)$Q_id, PDO::PARAM_INT);
          $stmt->bindValue(2, $ch);
          $stmt->bindValue(3, (int)$is_correct, PDO::PARAM_INT);
          $stmt->execute();
        } catch (PDOException $e) {
          print('Error:' . $e->getMessage());
          die();
        }
        $cnt += 1;
      }
    }
  }
}

unset($_SESSION['test']);
var_dump($_SESSION['test']);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>test view</title>
</head>

<body>
  <a href="clrsec.php">セッション変数を削除</a>
</body>

</html>