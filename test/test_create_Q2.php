<?php
include "./function/htmlspchar.php";
session_start();

if (isset($_POST['next'])) {
    if (isset($_POST['Q_number'])) {
        $Q_number = $_POST['Q_number'];

        $_SESSION['test'][$Q_number] = array(
            'number' => $Q_number,
            'text' => $_POST['main_text'],
            'checkbox_text' => $_POST['checkbox_text'],
            'is_correct' => $_POST['is_correct'],
            'use_editor' => isset($_POST['c_editor']),
            'use_flowchart' => isset($_POST['c_flowchart']),
            'use_math' => isset($_POST['c_math']),
            'editor_text' => $_POST['editor_text']
        );

        echo ('<pre>');
        var_dump($_SESSION['test']); // 確認用メッセージ
        echo ('</pre>');
        $Q_number++;
    }
    // echo "next"; // テストメッセージ
} elseif (isset($_POST['create'])) {
    $_SESSION['test']['iscreate'] = true;

    header("Location: ./test_view2.php");
    exit();
} else {
    $Q_number = 1;
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
    <script src="./option.js"></script>
    <script src="./function/post_hidden.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./fc/fc.css">
    <link rel="stylesheet" href="./math/math.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.12.0/dist/katex.min.css" integrity="sha384-AfEj0r4/OFrOo5t7NnNe46zW/tFgW6x/bCJG8FqQCEo3+Aro6EYUG4+cU+KJWu/X" crossorigin="anonymous">
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

    <form action="" method="post" id="main_form">
        <!-- テキスト -->
        <h4>問題文</h4>
        <textarea name="main_text" rows="8" cols="50" class="main_text_form"></textarea>

        <!-- オプション -->
        <div class="option_button">
            <input type="checkbox" name="c_editor">エディタを使用</input>
            <input type="checkbox" name="c_flowchart">フローチャートを使用</input>
            <input type="checkbox" name="c_math">手書き数式を使用</input>
        </div>

        <!-- エディタ -->
        <div class="ace_editor_div" style="display:none">
            <h4>エディタ</h4>
            <div class="btn-group">
                <div class="btn-group">
                    <!-- 拡大・縮小ボタン -->
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-search"></i> <span class="caret"></span></button>
                    <ul class="dropdown-menu" id="font-size">
                        <li><a href="#" data-size="10">小さい</a></li>
                        <li><a href="#" data-size="12">普通</a></li>
                        <li><a href="#" data-size="14">大きい</a></li>
                    </ul>
                </div>
                <!-- 言語モードボタン -->
                <div class="btn-group">
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="lang">言語<span class="caret"></span></button>
                    <ul class="dropdown-menu" id="language-mode">
                        <li><a href="#" data-language="python">Python</a></li>
                        <li><a href="#" data-language="java">Java</a></li>
                        <li><a href="#" data-language="ruby">Ruby</a></li>
                        <li><a href="#" data-language="html">HTML</a></li>
                        <li><a href="#" data-language="javascript">JavaScript</a></li>
                    </ul>
                </div>
                <!-- 保存ボタン -->
                <button id="save" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
                <!-- 読み込みボタン -->
                <button id="load" class="btn btn-default"><i class="glyphicon glyphicon-folder-open"></i></button>
                <a id="post">post</a>
            </div>

            <div id="ace_editor" style="height: 600px; width: 800px;"></div>
            <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ext-language_tools.js"></script>
            <script type="text/javascript" src="./ace_editor/ace_editor.js"></script>

            <script>
                // $('#post').click(function(e) {
                //     // console.log("test");
                //     var postData = editor.getValue();
                //     post('editor_text', {
                //         editor_text: postData
                //     });
                // });

                var observer = new MutationObserver(function(mutations) {
                    /** DOMの変化が起こった時の処理 */
                    // console.log('DOMが変化しました');
                    var postData = editor.getValue();
                    post('editor_text', {
                        editor_text: postData
                    });
                });

                /** 監視対象の要素オブジェクト */
                const elem = document.getElementById('ace_editor');
                console.log(elem);

                /** 監視時のオプション */
                const config = {
                    childList: true,
                    characterData: true,
                    subtree: true
                };

                /** 要素の変化監視をスタート */
                observer.observe(elem, config);
            </script>
            <div id="editor_input_div">
                <input type="hidden" id="editor_text">
            </div>
        </div>

        <!-- フローチャート -->
        <div class="flowchart_div flex-container" style="display:none">
            <div class="check_form_area">
                <ul>
                    <li>
                        <input type="radio" name="select_symbol" value="process" checked>処理
                    </li>
                    <li>
                        <input type="radio" name="select_symbol" value="decision">判断
                    </li>
                    <li>
                        <input type="radio" name="select_symbol" value="loop">ループ
                    </li>
                </ul>
            </div>
            <div class="main_form_area">
                <div id="input_0">
                    <input type="text" name="start" id="inputform_0" class="terminator" placeholder="開始">
                    <input type="radio" name="select_line" id="under_0" value="input_0" class="select_line" checked>
                </div>
                <div id="add_area"></div>
                <input type="text" name="last" id="inputform_last" class="terminator" placeholder="終了">

                <input type="button" value="追加" onclick="addForm()">
            </div>

            <script type="text/javascript" src="./fc/fc.js"></script>
        </div>

        <!-- 手書き数式 -->
        <div class="math_div">
            <h4>手書き数式</h4>
            <div id="result"></div>
            <div>
                <nav>
                    <div class="button-div">
                        <button id="clear" class="nav-btn btn-fab-mini btn-lightBlue" disabled>
                            <img src="./math/img/clear.svg">
                        </button>
                        <button id="undo" class="nav-btn btn-fab-mini btn-lightBlue" disabled>
                            <img src="./math/img/undo.svg">
                        </button>
                        <button id="redo" class="nav-btn btn-fab-mini btn-lightBlue" disabled>
                            <img src="./math/img/redo.svg">
                        </button>
                        <button onclick="getResult();">Result</button>
                    </div>
                    <div class="spacer"></div>
                    <button class="classic-btn" id="convert" disabled>Convert</button>
                </nav>
                <div id="editor" touch-action="none"></div>
            </div>
            <script defer src="https://cdn.jsdelivr.net/npm/katex@0.12.0/dist/katex.min.js" integrity="sha384-g7c+Jr9ZivxKLnZTDUhnkOnsh30B4H0rpLUpJ4jAIKs4fnJI+sEnkvrMWph2EDg4" crossorigin="anonymous"></script>
            <script type="text/javascript" src="./math/dist/iink.min.js"></script>
            <script type="text/javascript" src="./math/math.js"></script>
        </div>

        <!-- 選択肢 -->
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

        <!-- ボタン -->
        <div>
            <input type="submit" name="next" value="次へ" id="next_button">
            <input type="submit" name="create" value="テスト作成">
            <a href="clrsec.php">clear</a>
        </div>
    </form>
</body>

</html>