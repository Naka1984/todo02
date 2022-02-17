<?php

session_start();

//1. POSTデータ取得
// $id   = $_POST['id'];
// $title  = $_POST['title'];
// $content = $_POST['content'];

// $id = $_SESSION['id'];
$user_id    = $_SESSION['user_id']; //追加されています
$title = $_POST['title'];
$content = $_POST['text'];

//2. DB接続します
require_once('funcs.php');
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO message(id,title,text,user_id,destination_user_id,created_at)VALUES(:id,:title,:text,:user_id,:destination_user_id,sysdate());');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':text', $content, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':destination_user_id', $user_id, PDO::PARAM_STR);
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('select.php');
}
