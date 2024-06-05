<?php

include_once("funcs.php");
$pdo = db_conn();

// POSTデータを受け取る
$postId = $_POST['postId'];

// データ取得SQLを準備
$sql = "SELECT * FROM no1_post WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $postId, PDO::PARAM_INT);
$stmt->execute();

// データを取得
$postDetails = $stmt->fetch(PDO::FETCH_ASSOC);

// JSON形式で出力
echo json_encode($postDetails);
?>
