<?php 
/// まずは生のバイナリデータを取得
$raw_data = file_get_contents('php://input');
 
/// それを符号なしchar型の配列に変換
$unpacked = unpack('C*', $raw_data);
 
var_export($unpacked);
?>