<?php
//1.DB接続します
try {
    //Password:MAMP='root',XAMPP=''
    $pdo = new PDO('mysql:dbname=no1map;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DBConnection Error:' . $e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM no1_post";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if ($status == false) {
    $error = $stmt->errorInfo();
    exit("SQLError:" . $error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values, JSON_UNESCAPED_UNICODE);

?>

<!DOCTYPE html>
<html lang="ja">

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
                <?php foreach ($values as $value) : ?>
                    <div class="post">
                        <img src="<?php echo $value['image']; ?>" data-post-id="<?php echo $value['id']; ?>" alt="投稿画像">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="postDetails" style="display: none;"></div>

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

    <script>
        $(document).ready(function() {
            $('.post img').click(function() {
                var postId = $(this).data('post-id'); // 投稿IDを取得

                $.ajax({
                    url: 'get_post_details.php', // APIのURL
                    type: 'POST',
                    data: {
                        postId: postId
                    },
                    dataType: 'json',
                    success: function(data) {
                        // 成功時の処理
                        $('#postDetails').html(
                            '<p>店舗名: ' + data.storeName + '</p>' +
                            '<p>住所: ' + data.address + '</p>' +
                            '<p>URL: ' + data.url + '</p>' +
                            '<p>ジャンル: ' + data.genre + '</p>' +
                            '<p>シーン: ' + data.scene + '</p>' +
                            '<p>予算: ' + data.budget + '</p>' +
                            '<p>印象: ' + data.impression + '</p>'
                        );
                        $('#postDetails').css({
                            'display': 'block',
                            'width': '500px',
                            'height': '350px',
                            'color': '#000',
                            'background-color': '#fff',
                            'padding': '10px',
                            'border-radius': '10px',
                            'box-shadow': '0 0 10px rgba(0, 0, 0, 0.5)'
                        });
                    },
                    error: function() {
                        alert('情報の取得に失敗しました。');
                    }
                });
            });

            // モーダル外をクリックで閉じる
            $(window).click(function(e) {
                if (!$(e.target).closest('#postDetails').length) {
                    $('#postDetails').hide();
                }
            });
        });
    </script>


</body>

</html>