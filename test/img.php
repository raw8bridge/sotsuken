<?php
$id = $_GET['id'];
include './db/connectDB.php';
//画像取得
try {
    $sql = 'SELECT * FROM Flowchart WHERE ID = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    header('Content-Type: ' . $row['img_type']);
    echo $row['fc_content'];
    // var_dump($row);
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
}
$pdo = null;
?>