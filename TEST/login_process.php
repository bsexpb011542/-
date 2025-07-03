<?php
// login_process.php

session_start();

if (isset($_POST['login'])) {
    // 連接到資料庫
    $dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

    // 取得輸入的會員身分證字號、密碼、以及身分
    $member_id = mysqli_real_escape_string($dbConnection, $_POST['member_id']);
    $password = mysqli_real_escape_string($dbConnection, $_POST['password']);
    $user_type = mysqli_real_escape_string($dbConnection, $_POST['user_type']);

    // 根據身分來查詢資料表
    $table_name = ($user_type == 'customer') ? '會員資料表' : 'users';
    
    // 查詢資料庫
    $query = "SELECT * FROM $table_name WHERE 會員身分證字號 = '$member_id' AND 密碼 = '$password'";
    $result = mysqli_query($dbConnection, $query);

    // 檢查是否有匹配的記錄
    if (mysqli_num_rows($result) == 1) {
        // 登入成功
        $_SESSION['member_id'] = $member_id;
        $_SESSION['user_type'] = $user_type;
        
        // 根據身分導向至不同頁面
        if ($user_type == 'customer') {
            header('Location: member_dashboard.php'); // 導向至會員頁面
        } elseif ($user_type == 'admin') {
            header('Location: admin_dashboard.php'); // 導向至管理者頁面
        }
        
        exit();
    } else {
        // 登入失敗
        echo "登入失敗，請檢查會員身分證字號和密碼";
    }

    // 關閉資料庫連接
    mysqli_close($dbConnection);
}
?>
s