<?php
// require 'password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
require 'DBLogin.php';  // DBにログインするための色々
$login = new DBLogin();

// セッション開始
session_start();

$db['host'] = $login->host;  // DBサーバのURL
$db['user'] = $login->user;  // ユーザー名
$db['pass'] = $login->pass;  // ユーザー名のパスワード
$db['dbname'] = $login->dbname;  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["userid"])) {
        $errorMessage = 'ユーザ名が未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
        // 入力したユーザIDを格納
        $userid = $_POST["userid"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理    
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

            $stmt = $pdo->prepare('SELECT * FROM userData WHERE name = ?');
            $stmt->execute(array($userid));

            $password = $_POST["password"];

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // パスワードが正しいか確認
                if (password_verify($password, $row['password'])) {
                    session_regenerate_id(true);

                    // 入力したIDのユーザー名を取得
                    $id = $row['ID'];
                    $sql = "SELECT * FROM userData WHERE id = $id";  //入力したIDからユーザー名を取得
                    $stmt = $pdo->query($sql);
                    foreach ($stmt as $row) {
                        $row['name'];  // ユーザー名
                        $row['role_ID'];  // 役職ID
                        $row['class_ID']; // クラスID
                    }
                    $_SESSION["NAME"] = $row['name'];
                    $_SESSION["ROLE"] = $row['role_ID'];
                    $_SESSION["CLASS_ID"] = $row['class_ID'];
                    if($_SESSION["ROLE"] == '1'){
                        header("Location: Main_teacher.php");  // 教員用メイン画面へ遷移
                        exit();  // 処理終了
                    }elseif($_SESSION["ROLE"] == '2'){
                        $stmt = $pdo->prepare('SELECT * FROM Classes WHERE ID = ?');
                        $stmt->execute(array($_SESSION['CLASS_ID']));
                        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $_SESSION['CLASS_NAME'] = $row['class_name'];
                        }
                        header("Location: Main_student.php");  // 学生用メイン画面へ遷移
                        exit();  // 処理終了
                    }else{
                        $errorMessage = $_SESSION["ROLE"];
                    }
                } else {
                    // 認証失敗
                    $errorMessage = 'ユーザ名あるいはパスワードに誤りがあります。';
                }
            } else {
                // 4. 認証成功なら、セッションIDを新規に発行する
                // 該当データなし
                $errorMessage = 'ユーザ名あるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //$errorMessage = $sql;
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            echo $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>

<body>
    <h1>ログイン</h1>
    <form id="loginForm" name="loginForm" action="" method="post" style="width: 800px;">
        <fieldset>
            <legend>ログインフォーム</legend>
            <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
            <label for="userid">ユーザ名</label>
            <input type="text" id="userid" name="userid" placeholder="ユーザ名を入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
            <br>
            <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
            <br>
            <input type="submit" id="login" name="login" value="ログイン">
        </fieldset>
    </form>
</body>

</html>