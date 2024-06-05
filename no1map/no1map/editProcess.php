<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

include("funcs.php");
$pdo = db_conn();

// POSTデータ取得
$id = $_POST["id"];
$storeName = $_POST["storeName"];
$address = $_POST["address"];
$url = $_POST["url"];
$genre = $_POST["genre"];
$scene = $_POST["scene"];
$budget = $_POST["budget"];
$impression = $_POST["impression"];
$image = $_FILES['image'];

// 画像がアップロードされた場合の処理
if ($image['name'] != "") {
    $uploadDir = 'storeImage/'; // アップロードディレクトリ
    $uploadFile = $uploadDir . uniqid() . '_' . basename($image['name']);
    if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
        // ファイルが正常にアップロードされた場合、$uploadFileを使用してDBを更新
    } else {
        echo "画像のアップロードに失敗しました。";
        exit;
    }
} else {
    // 画像がアップロードされていない場合、既存の画像パスを使用
    $uploadFile = $_POST['existingImagePath'];
}

// データ更新SQL作成
$sql = "UPDATE no1_post SET storeName=:storeName, address=:address, url=:url, genre=:genre, scene=:scene, budget=:budget, impression=:impression, image=:image WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':storeName', $storeName, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->bindValue(':genre', $genre, PDO::PARAM_STR);
$stmt->bindValue(':scene', $scene, PDO::PARAM_STR);
$stmt->bindValue(':budget', $budget, PDO::PARAM_STR);
$stmt->bindValue(':impression', $impression, PDO::PARAM_STR);
$stmt->bindValue(':image', $uploadFile, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
    sql_error($stmt);
} else {
    redirect("mypage.php");
}
?>
