<?php
include "./function/htmlspchar.php";
session_start();

if ($_POST['status'] == 'next' || $_POST['status'] == 'start') {
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
            // var_dump($cnt); // 確認用
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
} elseif ($_POST['status'] == 'finish') {
    header("Location: ./test_finish.php");
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
    $stmt = $pdo->prepare('SELECT * FROM `QuestionTable` WHERE test_ID=?');
    $stmt->bindValue(1, (int)$id, PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll();
    $Q_row = $rows[(int)$Q_number - 1];
    $cnt = count($rows);

    // コード有無
    if ($Q_row['is_code'] == 1) {
        $stmt = $pdo->prepare('SELECT * FROM `Q_Code` WHERE Q_ID=?');
        $stmt->bindValue(1, (int)$Q_row['ID'], PDO::PARAM_INT);
        $stmt->execute();
        $codes = $stmt->fetchAll();
        $code = $codes[0];
        $use_code = true;
    } else {
        $use_code = false;
    }
    // フローチャート有無
    if ($Q_row['is_flowchart'] == 1) {
        $stmt = $pdo->prepare('SELECT * FROM `Flowchart` WHERE Q_ID=?');
        $stmt->bindValue(1, (int)$Q_row['ID'], PDO::PARAM_INT);
        $stmt->execute();
        $imgs = $stmt->fetchAll();
        $img = $imgs[0];
        $use_flowchart = true;
    } else {
        $use_flowchart = false;
    }

    if ($cnt == (int)$Q_number) {
        $status = "finish";
        $btn_txt = "回答";
    } else {
        $status = "next";
        $btn_txt = "次へ";
    }
    $page_txt = $Q_number . "/" . (string) $cnt;
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
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/highlight.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlightjs-line-numbers.js/2.3.0/highlightjs-line-numbers.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.1/styles/default.min.css">
    <link rel="stylesheet" href="style/ans.css">
    <title>テスト回答ページ</title>
</head>

<body>
    <h2><?php echo hsc($test_name); ?></h2>
    <h3>問<?php echo hsc($Q_row['Q_number']); ?></h3>
    <p><?php echo hsc($Q_row['Q_text']); ?></p>
    <div class="code_div">
    <?php
    if ($use_code) {
        echo ('<pre><code>');
        echo ($code['code']);
        echo ('</code></pre>');
    }
    ?>
    </div>
    <script>
        hljs.initHighlightingOnLoad();
        hljs.initLineNumbersOnLoad();
    </script>

    <?php
    if ($use_flowchart) {
        echo ('<img src="img.php?id=' . $img['ID'] . '" class="fc_img">');
    }
    ?>

    <form action="test_ans.php" method="post">
        <?php
        foreach ($rows as $ch) {
            echo '<input type="checkbox" name="ans[]" value="' . hsc($ch['ID']) . '">';
            echo hsc($ch['checkbox_text']);
            echo "<br>";
        }
        ?>
        <input type="hidden" name='test_id' value=<?php echo hsc($id); ?>>
        <input type="hidden" name='Q_number' value=<?php echo hsc($Q_number); ?>>
        <input type="hidden" name='status' value=<?php echo ("\"" . $status . "\""); ?>>
        <input type="submit" value=<?php echo ("\"" . $btn_txt . "\""); ?>>
    </form>
    <?php echo ($page_txt); ?>

</body>

</html>