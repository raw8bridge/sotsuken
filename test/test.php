<?php
require '../DBLogin.php';
$login = new DBLogin();
?>

<html>

<head></head>

<body>
    <h1>test</h1>
    <?php $login->printDB() ?>
    
</body>

</html>