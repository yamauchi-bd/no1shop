<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

//１．PHP
$id = $_GET["id"]; //GET

include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM no1_post WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$row = $stmt->fetch();
// $values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>

<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>No.1 入れ替え</title>
  <link rel="stylesheet" href="../map.css">
  <script src="https://kit.fontawesome.com/17c882a708.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>



<!-- Main[Start] -->
<div id="postFormContainer">
        <form id="postForm" action="editProcess.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$row['id']?>">
            <input type="hidden" name="existingImagePath" value="<?=$row['image']?>"> <!-- ここ大事！ -->
            <input name="storeName" type="text" id="storeNamePost" value="<?=$row["storeName"] ?>">
            <input name="address" type="text" id="addressPost" value="<?=$row["address"] ?>">
            <input name="url" type="text" id="urlPost" value="<?=$row["url"] ?>">
            <select name="genre" id="genrePost">
              <option value="" <?= $row['genre'] == '' ? 'selected' : '' ?>>ジャンル</option>
                <option value="焼肉" <?= $row['genre'] == '焼肉' ? 'selected' : '' ?>>焼肉</option>
                <option value="焼き鳥" <?= $row['genre'] == '焼き鳥' ? 'selected' : '' ?>>焼き鳥</option>
                <option value="寿司" <?= $row['genre'] == '寿司' ? 'selected' : '' ?>>寿司</option>
                <option value="居酒屋" <?= $row['genre'] == '居酒屋' ? 'selected' : '' ?>>居酒屋</option>
                <option value="お好み焼き･もんじゃ" <?= $row['genre'] == 'お好み焼き･もんじゃ' ? 'selected' : '' ?>>お好み焼き･もんじゃ</option>
                <option value="ラーメン" <?= $row['genre'] == 'ラーメン' ? 'selected' : '' ?>>ラーメン</option>
                <option value="カレー" <?= $row['genre'] == 'カレー' ? 'selected' : '' ?>>カレー</option>
                <option value="フレンチ" <?= $row['genre'] == 'フレンチ' ? 'selected' : '' ?>>フレンチ</option>
                <option value="イタリアン" <?= $row['genre'] == 'イタリアン' ? 'selected' : '' ?>>イタリアン</option>
                <option value="日本料理" <?= $row['genre'] == '日本料理' ? 'selected' : '' ?>>日本料理</option>
                <option value="中華料理" <?= $row['genre'] == '中華料理' ? 'selected' : '' ?>>中華料理</option>
                <option value="韓国料理" <?= $row['genre'] == '韓国料理' ? 'selected' : '' ?>>韓国料理</option>
                <option value="アジア料理" <?= $row['genre'] == 'アジア料理' ? 'selected' : '' ?>>アジア料理</option>
                <option value="エスニック料理" <?= $row['genre'] == 'エスニック料理' ? 'selected' : '' ?>>エスニック料理</option>
                <option value="創作料理" <?= $row['genre'] == '創作料理' ? 'selected' : '' ?>>創作料理</option>
                <option value="ビストロ" <?= $row['genre'] == 'ビストロ' ? 'selected' : '' ?>>ビストロ</option>
                <option value="スイーツ" <?= $row['genre'] == 'スイーツ' ? 'selected' : '' ?>>スイーツ</option>
                <option value="カフェ･喫茶店" <?= $row['genre'] == 'カフェ･喫茶店' ? 'selected' : '' ?>>カフェ･喫茶店</option>
                <option value="ビアバー" <?= $row['genre'] == 'ビアバー' ? 'selected' : '' ?>>ビアバー</option>
                <option value="ワインバー" <?= $row['genre'] == 'ワインバー' ? 'selected' : '' ?>>ワインバー</option>
                <option value="日本酒バー" <?= $row['genre'] == '日本酒バー' ? 'selected' : '' ?>>日本酒バー</option>
            </select>
            <select name="scene" id="scenePost">
                <option value="" <?= $row['scene'] == '' ? 'selected' : '' ?>>利用シーン</option>
                <option value="カジュアル" <?= $row['scene'] == 'カジュアル' ? 'selected' : '' ?>>カジュアル</option>
                <option value="デート" <?= $row['scene'] == 'デート' ? 'selected' : '' ?>>デート</option>
                <option value="記念日" <?= $row['scene'] == '記念日' ? 'selected' : '' ?>>記念日</option>
                <option value="接待･会食" <?= $row['scene'] == '接待･会食' ? 'selected' : '' ?>>接待･会食</option>
                <option value="歓送迎会" <?= $row['scene'] == '歓送迎会' ? 'selected' : '' ?>>歓送迎会</option>
                <option value="忘年会･新年会" <?= $row['scene'] == '忘年会･新年会' ? 'selected' : '' ?>>忘年会･新年会</option>
            </select>
            <select name="budget" id="budgetPost">
                <option value="" <?= $row['budget'] == '' ? 'selected' : '' ?>>予算</option>
                <option value="〜1000円" <?= $row['budget'] == '〜1000円' ? 'selected' : '' ?>>〜1000円</option>
                <option value="1000円〜5000円" <?= $row['budget'] == '1000円〜5000円' ? 'selected' : '' ?>>1000円〜5000円</option>
                <option value="5000円〜10000円" <?= $row['budget'] == '5000円〜10000円' ? 'selected' : '' ?>>5000円〜10000円</option>
                <option value="10000円〜30000円" <?= $row['budget'] == '10000円〜30000円' ? 'selected' : '' ?>>10000円〜30000円</option>
                <option value="30000円〜" <?= $row['budget'] == '30000円〜' ? 'selected' : '' ?>>30000円〜</option>
            </select>
            <textarea name="impression" id="impressionPost"><?= $row['impression'] ?></textarea>
            <div class="custom-file-upload">
                <input name="image" type="file" id="imagePost" style="display:none;">
                <span onclick="document.getElementById('imagePost').click();">画像を追加 <i
                    class="fa-solid fa-square-plus"></i></span>
                <span id="fileChosen">選択されていません</span>
            </div>
            <button type="submit" id="submitPost">No.1を更新</button>
            <span id="closePostForm" style="cursor: pointer;"><i class="fa-solid fa-xmark"></i></span>
        </form>
    </div>
<!-- Main[End] -->

<script>
$(document).ready(function() {
    $('#imagePost').change(function() {
        var file = $(this)[0].files[0];
        if (file) {
            $('#fileChosen').text(file.name);
        } else {
            $('#fileChosen').text('選択されていません');
        }
    });

    $('#closePostForm').click(function() {
        window.location.href = 'mypage.php'; // mypage.phpにリダイレクト
    });
});
</script>


</body>
</html>



