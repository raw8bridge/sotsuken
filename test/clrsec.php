<?php
session_start();
    unset($_SESSION['test']);
    echo '<a href="Main_teacher.php">戻る</a>';
    // $no = $_SESSION['no'];
    // $no = 1 / 0;
    // print_r(error_get_last ( ));
    print_r($_SESSION['test']);
