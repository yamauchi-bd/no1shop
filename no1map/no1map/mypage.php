<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>myPage</title>
    <link rel="stylesheet" href="../mypage.css">
    <script src="https://kit.fontawesome.com/17c882a708.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<?php
session_start(); // セッションを開始

// ファイルを変数に格納
$filename = 'profileData.csv';

// fopenでファイルを開く（'r'は読み込みモードで開く）
$fp = fopen($filename, 'r');

// fgetsでファイルを読み込み、変数に格納
$data = fgetcsv($fp);
$nickname = $data[0];
$genre = $data[1];

// セッションに画像のパスを保存
$_SESSION['profilePicture'] = $data[2];


// fcloseでファイルを閉じる
fclose($fp);
?>


<body>
    <div id="myProfileContainer">
        <div class="profile-header">
        <div class="profile-pic" style="background-image: url('<?php echo $_SESSION['profilePicture']; ?>');"></div>
            <div class="profile-content">
                <h1>ニックネーム:<?php echo $nickname; ?></h1>
                <p>好きなジャンル:<?php echo $genre; ?></p>
            </div>
        </div>
        <div class="profile-posts">
            <h2>･･･ 投稿 ･･･</h2>
            <div class="posts-container">

                <!-- 他の投稿も同様に追加 -->
            </div>
        </div>
    </div>

    <div class="footer">
        <button id="map" onclick="window.location.href='map.html';">
            <i class="fa-solid fa-location-dot fa-2x"></i>
            マップ
        </button>
        <button id="post">
            <i class="far fa-plus-square fa-2x"></i>
            投稿
        </button>
        <button id="find" onclick="window.location.href='find.html';">
            <i class="fa-brands fa-instagram fa-2x"></i>
            発見
        </button>
    </div>
</body>

</html>