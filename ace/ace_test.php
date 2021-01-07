<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Ace Editor sample</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="btn-group">
        <div class="btn-group">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-search"></i> <span class="caret"></span></button>
            <ul class="dropdown-menu" id="font-size">
                <li><a href="#" data-size="10">小さい</a></li>
                <li><a href="#" data-size="12">普通</a></li>
                <li><a href="#" data-size="14">大きい</a></li>
            </ul>
        </div>
        <button id="bold" class="btn btn-default"><i class="glyphicon glyphicon-bold"></i></button>
        <button id="save" class="btn btn-default"><i class="glyphicon glyphicon-floppy-save"></i></button>
        <button id="load" class="btn btn-default"><i class="glyphicon glyphicon-folder-open"></i></button>
        <button id="post" class="btn btn-default">送信</button>
    </div>

    <div id="editor" style="height: 600px"></div>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ext-language_tools.js"></script>
    <script src="./post.js"></script>

    <script>
        var editor = ace.edit("editor");
        editor.$blockScrolling = Infinity;
        editor.setOptions({
            enableBasicAutocompletion: true,
            enableSnippets: true,
            enableLiveAutocompletion: true
        });
        editor.setTheme("ace/theme/monokai");
        editor.getSession().setMode("ace/mode/html");

        $('#font-size').click(function(e) {
            editor.setFontSize($(e.target).data('size'));
        });
        $('#bold').click(function(e) {
            editor.insert('<strong>' + editor.getCopyText() + '</strong>');
        });
        $('#save').click(function(e) {
            localStorage.text = editor.getValue();
            alert("保存しました。");
        });
        $('#load').click(function(e) {
            if (!confirm("読み込みますか？")) return;
            editor.setValue(localStorage.text, -1);
        });
        $('#post').click(function(e) {
            var postData = editor.getValue();
            // console.log(postData);
            post('index.php', {txt:postData});
        });
    </script>
    <!-- 参考: https://qiita.com/naga3/items/1bc268243f2e8a6514e5 -->
</body>

</html>