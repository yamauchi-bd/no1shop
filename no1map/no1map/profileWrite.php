<?php
include("funcs.php");
ini_set('display_errors', 1);

//文字作成
$nickname = $_POST['nickname'];
$favoriteGenre = $_POST['favoriteGenre'];
$profilePicture = $_FILES['profilePicture'];

$uploadPath = 'uploads/' . $profilePicture['name']; // 保存先のパスを設定

if (move_uploaded_file($profilePicture['tmp_name'], $uploadPath)) {
    // ファイルの移動に成功した場合の処理
    $str = $nickname . "," . $favoriteGenre . "," . $uploadPath;
    // 以降の処理を続ける
} else {
    // ファイルの移動に失敗した場合の処理
    echo "ファイルのアップロードに失敗しました";
}

//File書き込み
$file = fopen("profileData.csv","a");	// ファイル読み込み
fwrite($file, $str."\n");
fclose($file);

header("Location: mypage.php");
exit();
?>

<html>
<head>
<meta charset="utf-8">
<title>File書き込み</title>
</head>
<body>
<h1>書き込みしましたyo。</h1>
</body>
</html>