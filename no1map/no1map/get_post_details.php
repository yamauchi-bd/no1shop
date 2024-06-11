<?php
include_once("funcs.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['postId'];

    // DB接続
    try {
        $pdo = db_conn();
    } catch (PDOException $e) {
        echo json_encode(['error' => 'DBConnection Error: ' . $e->getMessage()]);
        exit();
    }

    // 投稿詳細を取得
    $stmt = $pdo->prepare("
        SELECT no1_post.storeName, no1_post.address, no1_post.url, no1_post.genre, no1_post.scene, no1_post.budget, no1_post.impression, user_table.nickname 
        FROM no1_post 
        JOIN user_table ON no1_post.userID = user_table.loginID 
        WHERE no1_post.id = :postId
    ");
    $stmt->bindValue(':postId', $postId, PDO::PARAM_INT);
    $status = $stmt->execute();

    if ($status == false) {
        $error = $stmt->errorInfo();
        echo json_encode(['error' => 'ErrorQuery: ' . $error[2]]);
    } else {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            // nicknameをエンコード
            $result['nickname'] = urlencode($result['nickname']);
            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'No data found']);
        }
    }
}
?>