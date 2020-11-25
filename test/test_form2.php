<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>入力項目を動的に追加・削除</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="./test_script.js"></script>
<!-- Bootstrap CSS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<body>
<div>1</div>
<input type="text" name="textarea[0]" class="toiawase" placeholder="選択肢を入力">
<div class="box" data-formno="0">
  <div id="input_pluralBox">
    <div id="input_plural">     
      <div class="no">2</div>
      <input type="text" name="textarea[1]" class="toiawase" placeholder="選択肢を入力"> 
      <input type="button" value="－" class="deletformbox">
      <input type="button" value="＋" class="addformbox">
    </div>
  </div>
</div>
    </body>
</html>