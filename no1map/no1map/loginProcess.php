<?php
//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値
$loginId = htmlspecialchars($_POST["loginId"], ENT_QUOTES, 'UTF-8'); //loginId
$loginPass = htmlspecialchars($_POST["loginPass"], ENT_QUOTES, 'UTF-8'); //loginPass


//1.  DB接続します
include("funcs.php");
$pdo = db_conn();

//2. データ登録SQL作成
//* PasswordがHash化→条件はloginIdのみ！！


$stmt = $pdo->prepare("SELECT * FROM user_table WHERE loginId=:loginId"); 
$stmt->bindValue(':loginId', $loginId, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得する方法
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()

//5.該当１レコードがあればSESSIONに値を代入
//入力したPasswordと暗号化されたPasswordを比較！[戻り値：true,false]
$pw = password_verify($loginPass, $val["loginPass"]); //$lpw = password_hash($lpw, PASSWORD_DEFAULT);   //パスワードハッシュ化
if($pw){ 
  //Login成功時
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["kanri_flg"] = $val['kanri_flg'];
  $_SESSION["nickname"]      = $val['nickname'];
  $_SESSION["favoriteGenre"] = $val['favoriteGenre'];
  $_SESSION["profilePicture"] = $val['profilePicture'];
  $_SESSION["profilePicturePath"] = $val['profilePicture'];
  $_SESSION["loginId"] = $loginId; // ログインIDをセッションに保存
  //Login成功時
  redirect("mypage.php");

}else{
  //Login失敗時(login.phpへ)
  redirect("login.php");

}

exit();