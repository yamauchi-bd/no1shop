<?php
session_start(); // セッションを開始

include_once("funcs.php");
// エラー表示を有効にする
ini_set("display_errors", 1);
error_reporting(E_ALL);

// デバッグ用にセッション変数の内容を出力
var_dump($_SESSION['loginId']);

if (!isset($_SESSION['loginId'])) {
    exit('ログインが必要です。');
}

// 1. POSTデータ取得
$storeName = $_POST['storeName'];
$address = $_POST['address'];
$url = $_POST['url'];
$genre = $_POST['genre'];
$scene = $_POST['scene'];
$budget = $_POST['budget'];
$impression = $_POST['impression'];
$image = $_FILES['image'];
$storeImagePath = 'storeImage/' . uniqid() . '_' . basename($image['name']); // 一意のIDを付加して保存先のパスを設定

// 2. DB接続
try {
  $pdo = db_conn();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードを例外に設定
} catch (PDOException $e) {
  exit('DB_CONNECT_ERROR:'.$e->getMessage());
}

// 画像ファイルをアップロードする
if(move_uploaded_file($image['tmp_name'], $storeImagePath)) {
  // 3. データ登録SQL作成
  $sql = "INSERT INTO no1_post (userId, storeName, address, url, genre, scene, budget, impression, image, indate) VALUES (:userId, :storeName, :address, :url, :genre, :scene, :budget, :impression, :storeImagePath, sysdate())";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':userId', $_SESSION['loginId'], PDO::PARAM_STR);
  $stmt->bindValue(':storeName', $storeName, PDO::PARAM_STR);
  $stmt->bindValue(':address', $address, PDO::PARAM_STR);
  $stmt->bindValue(':url', $url, PDO::PARAM_STR);
  $stmt->bindValue(':genre', $genre, PDO::PARAM_STR);
  $stmt->bindValue(':scene', $scene, PDO::PARAM_STR);
  $stmt->bindValue(':budget', $budget, PDO::PARAM_STR);
  $stmt->bindValue(':impression', $impression, PDO::PARAM_STR);
  $stmt->bindValue(':storeImagePath', $storeImagePath, PDO::PARAM_STR);
  $status = $stmt->execute();

  // 4. データ登録処理後
  if($status == false){
    // SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("SQL_ERROR:".$error[2]);
  }else{
    // 5. リダイレクト
    header("Location: mypage.php");
    exit();
  }
} else {
  echo 'ファイルのアップロード中にエラーが発生しました。';
}
?>
