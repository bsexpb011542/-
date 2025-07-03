<?php
// delete_member.php

session_start();
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit();
}

// 連接到資料庫
$dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// 檢查連接是否成功
if (!$dbConnection) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 處理會員刪除
if (isset($_POST['delete_member'])) {
    $member_id_to_delete = strtoupper($_POST['member_id_to_delete']);

    // 檢查會員身分證字號格式
    if (preg_match('/^[A-Z]\d{9}$/', $member_id_to_delete)) {
        // 檢查會員是否存在
        $check_query = "SELECT * FROM 會員資料表 WHERE 會員身分證字號 = '$member_id_to_delete'";
        $check_result = mysqli_query($dbConnection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // 轉移會員資料到靜止會員資料表
            $select_query = "SELECT * FROM 會員資料表 WHERE 會員身分證字號 = '$member_id_to_delete'";
            $select_result = mysqli_query($dbConnection, $select_query);

            if ($row = mysqli_fetch_assoc($select_result)) {
                $insert_query = "INSERT INTO 靜止會員資料表 (會員身分證字號, 密碼, 會員姓名, 電話, 手機號碼, Email, 是否加入東海水果公司之Line, 住址, 年齡, 照片, 會員折扣)
                                 VALUES ('{$row['會員身分證字號']}', '{$row['密碼']}', '{$row['會員姓名']}', '{$row['電話']}', '{$row['手機號碼']}', '{$row['Email']}', '{$row['是否加入東海水果公司之Line']}', '{$row['住址']}', '{$row['年齡']}', '{$row['照片']}', '{$row['會員折扣']}')";
                
                if (mysqli_query($dbConnection, $insert_query)) {
                    // 刪除原會員資料
                    $delete_query = "DELETE FROM 會員資料表 WHERE 會員身分證字號 = '$member_id_to_delete'";
                    if (mysqli_query($dbConnection, $delete_query)) {
                        $success_message = "會員資料刪除成功，並轉移至靜止會員資料表。";
                    } else {
                        $error_message = "刪除會員資料失敗: " . mysqli_error($dbConnection);
                    }
                } else {
                    $error_message = "轉移會員資料至靜止會員資料表失敗: " . mysqli_error($dbConnection);
                }
            }
        } else {
            $error_message = "會員身分證字號不存在。";
        }
    } else {
        $error_message = "會員身分證字號格式錯誤，請輸入正確格式 (例如：A123456789)。";
    }
}

// 關閉資料庫連接
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>刪除會員資料</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?user,profile') no-repeat center center/cover;
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        .hero-section h1 {
            color: black !important;
        }
    </style>
</head>
<body>

<!-- 導覽列 -->
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="#">🗑️ 刪除會員資料</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="member_dashboard.php">會員中心</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">登出</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero 區塊 -->
<section class="hero-section text-center py-5">
    <div class="container">
        <h1>刪除會員資料</h1>
        <p class="lead">將會員資料轉移至靜止會員資料表。</p>
    </div>
</section>

<!-- 刪除會員表單 -->
<section class="container my-5">
    <h3 class="text-center mb-4">🧑‍🤝‍🧑 刪除會員</h3>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success text-center"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post" class="d-flex justify-content-center">
        <input type="text" name="member_id_to_delete" class="form-control w-50 me-2" placeholder="輸入會員身分證字號" pattern="[A-Z]\d{9}" title="請輸入正確格式，例如：A123456789" required>
        <button type="submit" name="delete_member" class="btn btn-danger">刪除會員</button>
    </form>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
