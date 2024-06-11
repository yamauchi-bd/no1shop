<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../login.css">
    <script src="https://kit.fontawesome.com/17c882a708.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>No.1 MAP</title>
</head>

<body>
    <!-- <div id="loginContainer">
        <p>みんなのNo.1が集まれば<br>最強グルメマップが完成‼︎</p>
        <h1>『 No.1グルメMAP 』</h1>
        <button id="loginWithGoogle">アカウント登録</button>
    </div> -->

    <div id="profileContainer">
        <h1>プロフィールを登録しよう</h1>
        <div class="flex-container">
            <form action="loginInsert.php" method="post" enctype="multipart/form-data">
                <div class="profile-pic" style="background-image: url('path_to_default_profile_picture.jpg');" onclick="document.getElementById('profilePictureInput').click();">
                    <span>画像を選ぶ <i class="fa-solid fa-square-plus"></i></span>
                </div>
                </div>
                <input type="file" name="profilePicture" id="profilePictureInput" style="display: none;" onchange="updateProfilePicturePreview(this)">
                <div class="profile-info">
                    <input type="text" id="nickname" placeholder="ニックネーム" class="nickname" name="nickname">
                    <input type="text" id="loginId" placeholder="ログインID" class="loginId" name="loginId">
                    <input type="password" id="loginPass" placeholder="ログインパスワード" class="loginPass" name="loginPass">
                    <select id="favoriteGenre" class="genre" name="favoriteGenre">
                        <option value="">好きなお店･料理のジャンル</option>
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
                </div>
        </div>
        <button onclick="saveProfile()" class="register-button">登録する</button>
        </form>
    </div>

    <div id="loginContainer">
        <h1>ログイン</h1>
        <form action="loginProcess.php" method="post">
            <div class="form-group">
                <label for="loginId">ログインID:</label>
                <input type="text" id="loginId" name="loginId" required>
            </div>
            <div class="form-group">
                <label for="loginPass">パスワード:</label>
                <input type="password" id="loginPass" name="loginPass" required>
            </div>
            <button type="submit" class="login-button">ログイン</button>
        </form>
    </div>

    

    <script>
        function updateProfilePicturePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-pic').style.backgroundImage = 'url(' + e.target.result + ')';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var favoriteGenreSelect = document.getElementById('favoriteGenre');

            function updateSelectColor() {
                favoriteGenreSelect.style.color = favoriteGenreSelect.value === "" ? 'lightgray' : 'black';
            }
            favoriteGenreSelect.addEventListener('change', updateSelectColor);
            updateSelectColor();
        });
    </script>

</body>

</html>