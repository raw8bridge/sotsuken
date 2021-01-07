<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if(isset($_POST['txt'])){
        echo "<pre>";
        echo(htmlspecialchars($_POST['txt'], ENT_QUOTES));
        echo "</pre>";
    } else {
        echo "POST失敗";
    }
    ?>
</body>

</html>