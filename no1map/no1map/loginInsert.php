<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

session_start();
include("funcs.php");

$pdo = db_conn();

$loginId = $_POST["loginId"];
$loginPass = $_POST["loginPass"];
$nickname = $_POST["nickname"];
$favoriteGenre = $_POST["favoriteGenre"];
$profilePicture = $_FILES['profilePicture'];
$profilePicturePath = 'profile_picture_path/' . uniqid() . '_' . basename($profilePicture['name']); // 一意のIDを付加して保存先のパスを設定

// パスワードをハッシュ化し上書き
$loginPASS = password_hash($loginPass, PASSWORD_DEFAULT);

// プロファイル画像をアップロード
if(move_uploaded_file($profilePicture['tmp_name'], $profilePicturePath)){
    $stmt = $pdo->prepare("UPDATE user_table SET profilePicture=:profilePicture WHERE loginId=:loginId"); 
    $stmt->bindValue(':loginId', $loginId, PDO::PARAM_STR);
    $stmt->bindValue(':profilePicture', $profilePicturePath, PDO::PARAM_STR);
    $status = $stmt->execute();
    if($status == false){
        sql_error($stmt);
    }
  } else {
    // ファイルのアップロードに失敗した場合の処理
    redirect("upload_error.php");
    exit();
  }

// データベースにユーザー情報を登録
$stmt = $pdo->prepare("INSERT INTO user_table (loginId, loginPASS, nickname, favoriteGenre, profilePicture) VALUES (:loginId, :loginPASS, :nickname, :favoriteGenre, :profilePicture)");
$stmt->bindValue(':loginId', $loginId, PDO::PARAM_STR);
$stmt->bindValue(':loginPASS', $loginPASS, PDO::PARAM_STR);
$stmt->bindValue(':nickname', $nickname, PDO::PARAM_STR);
$stmt->bindValue(':favoriteGenre', $favoriteGenre, PDO::PARAM_STR);
$stmt->bindValue(':profilePicture', $profilePicturePath, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){
    sql_error($stmt);
} else {
    redirect("mypage.php"); // 登録成功後、マイページにリダイレクト
}

exit();
?>