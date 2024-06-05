<?php
include_once("funcs.php");
//1.DB接続します
try {
    $pdo = db_conn();
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
                        <img src="<?php echo $value['image']; ?>" data-post-id="<?=$value['id']; ?>" alt="投稿画像">
                        <a href="edit.php?id=<?=$value["id"]?>">【更新】</a>
                        <a href="delete.php?id=<?=$value["id"]?>" onclick="return confirm('本当に削除しますか？');">【削除】</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="postDetails" style="display: none;"></div>

    <!-- 投稿画面 -->
    <div id="postFormContainer" style="display: none;">
        <form id="postForm" action="postWrite.php" method="post" enctype="multipart/form-data">
            <input name="storeName" type="text" id="storeNamePost" placeholder="店舗名" required>
            <input name="address" type="text" id="addressPost" placeholder="住所" required>
            <input name="url" type="text" id="urlPost" placeholder="URL">
            <select name="genre" id="genrePost" required>
                <option value="">ジャンル</option>
                <option value="焼肉">焼肉</option>
                <option value="焼き鳥">焼き鳥</option>
                <option value="寿司">寿司</option>
                <option value="居酒屋">居酒屋</option>
                <option value="お好み焼き･もんじゃ">お好み焼き･もんじゃ</option>
                <option value="ラーメン">ラーメン</option>
                <option value="カレー">カレー</option>
                <option value="フレンチ">フレンチ</option>
                <option value="イタリアン">イタリアン</option>
                <option value="日本料理">日本料理</option>
                <option value="中華料理">中華料理</option>
                <option value="韓国料理">韓国料理</option>
                <option value="アジア料理">アジア料理</option>
                <option value="エスニック料理">エスニック料理</option>
                <option value="創作料理">創作料理</option>
                <option value="ビストロ">ビストロ</option>
                <option value="スイーツ">スイーツ</option>
                <option value="カフェ･喫茶店">カフェ･喫茶店</option>
                <option value="ビアバー">ビアバー</option>
                <option value="ワインバー">ワインバー</option>
                <option value="日本酒バー">日本酒バー</option>
            </select>
            <select name="scene" id="scenePost" required>
                <option value="" selected>利用シーン</option>
                <option value="カジュアル">カジュアル</option>
                <option value="デート">デート</option>
                <option value="記念日">記念日</option>
                <option value="接待･会食">接待･会食</option>
                <option value="歓送迎会">歓送迎会</option>
                <option value="忘年会･新年会">忘年会･新年会</option>
            </select>
            <select name="budget" id="budgetPost" required>
                <option value="" selected>予算</option>
                <option value="〜1000円">〜1000円</option>
                <option value="1000円〜5000円">1000円〜5000円</option>
                <option value="5000円〜10000円">5000円〜10000円</option>
                <option value="10000円〜30000円">10000円〜30000円</option>
                <option value="30000円〜">30000円〜</option>
            </select>
            <textarea name="impression" id="impressionPost" placeholder="おすすめポイント"></textarea>
            
            <div class="custom-file-upload">
                <input name="image" type="file" id="imagePost" style="display:none;">
                <span onclick="document.getElementById('imagePost').click();">画像を追加 <i
                    class="fa-solid fa-square-plus"></i></span>
                <span id="fileChosen">選択されていません</span>
            </div>
            <button type="submit" id="submitPost">投稿</button>
            <button id="closePostForm"><i class="fa-solid fa-xmark"></i></button>
        </form>
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
                            '<p>おすすめ: ' + data.impression + '</p>'
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

        // 投稿画面の表示
        $("#post").on("click", function () {
            $("#postFormContainer").fadeIn();
        });
        $("#closePostForm").on("click", function () {
            $("#postFormContainer").fadeOut();
        });

        // <!-- 投稿フォームのセレクトボックスで値が選択されていない時のフォントカラーを設定 -->
        document.addEventListener('DOMContentLoaded', function () {
            // 投稿フォームとマップフィルター内のセレクト要素を対象にする
            var postFormSelects = document.querySelectorAll('#postForm select');
            var mapFilterSelects = document.querySelectorAll('#mapFilter select');

            function updateSelectColor(select, emptyColor, filledColor) {
                select.addEventListener('change', function () {
                    this.style.color = this.value === "" ? emptyColor : filledColor;
                });
                // 初期ロード時にも適用
                select.style.color = select.value === "" ? emptyColor : filledColor;
            }

            postFormSelects.forEach(function (select) {
                updateSelectColor(select, 'lightgray', 'black'); // 投稿フォーム用の色設定
            });

            mapFilterSelects.forEach(function (select) {
                updateSelectColor(select, 'gray', 'black'); // マップフィルター用の色設定
            });

            // document.getElementById('customFileBtn').addEventListener('click', function () {
            //     document.getElementById('imagePost').click();
            // });

                document.getElementById('imagePost').addEventListener('change', function () {
                    var fileName = this.files[0] ? this.files[0].name : "選択されていません";
                    document.getElementById('fileChosen').textContent = fileName;
                });
        });

        // ジャンルフィルターの変更を監視
        document.getElementById('genreFilter').addEventListener('change', function () {
            filterMarkersByGenre(this.value);
        });

        // 利用シーンフィルターの変更を監視
        document.getElementById('sceneFilter').addEventListener('change', function () {
            filterMarkersByScene(this.value);
        });

        // 予算フィルターの変更を監視
        document.getElementById('budgetFilter').addEventListener('change', function () {
            filterMarkersByBudget(this.value);
        });

        // ジャンルに基づいてマーカーをフィルタリングする関数
        function filterMarkersByGenre(genre) {
            markers.forEach(marker => {
                if (genre === "" || marker.genre === genre) {
                    marker.setMap(map);  // ジャンルが一致する場合はマーカーを表示
                } else {
                    marker.setMap(null);  // 一致しない場合はマーカーを非表示
                }
            });
        }

        // 利用シーンに基づいてマーカーをフィルタリングする関数
        function filterMarkersByScene(scene) {
            markers.forEach(marker => {
                if (scene === "" || marker.scene === scene) {
                    marker.setMap(map);  // 利用シーンが一致する場合はマーカーを表示
                } else {
                    marker.setMap(null);  // 一致しない場合はマーカーを非表示
                }
            });
        }

        // 予算に基づいてマーカーをフィルタリングする関数
        function filterMarkersByBudget(budget) {
            markers.forEach(marker => {
                if (budget === "" || marker.budget === budget) {
                    marker.setMap(map);  // 予算が一致する場合はマーカーを表示
                } else {
                    marker.setMap(null);  // 一致しない場合はマーカーを非表示
                }
            });
        }
    </script>

    


</body>

</html>