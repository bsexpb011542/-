<?php
// admin_dashboard.php

session_start();

// 檢查是否登入，並且身分是管理者
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// 連接到資料庫
$dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// 取得管理者的資訊
$admin_id = $_SESSION['member_id'];
$query = "SELECT * FROM users WHERE 會員身分證字號 = '$admin_id'";
$result = mysqli_query($dbConnection, $query);

// 檢查是否有匹配的記錄
if (mysqli_num_rows($result) == 1) {
    $admin_info = mysqli_fetch_assoc($result);
} else {
    echo "找不到管理者的資訊";
    exit();
}

// 關閉資料庫連接
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者儀表板</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?office') no-repeat center center/cover;
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
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 管理者儀表板</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="logout.php">登出</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero 區塊 -->
<section class="hero-section text-center py-5">
    <div class="container">
        <h1>管理者儀表板</h1>
        <p class="lead">歡迎回來，<?php echo htmlspecialchars($admin_info['會員身分證字號']); ?>！</p>
    </div>
</section>

<!-- 功能區塊 -->
<section class="container my-5">
    <h3 class="text-center mb-4">📊 系統管理功能</h3>

    <div class="row g-4">
        <!-- 水果資料表 -->
        <div class="col-md-4">
            <h3>🍇 水果資料表</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item"><a href="increase_fruit.php">水果新增</a></li>
                <li class="list-group-item"><a href="search_fruit.php">水果查詢</a></li>
                <li class="list-group-item"><a href="delete_fruit.php">水果查詢已刪除資料</a></li>
                <li class="list-group-item"><a href="fix_fruit.php">水果修改</a></li>
                <li class="list-group-item"><a href="fruita01.php">查詢公司內水果數量與價值小計</a></li>
                <li class="list-group-item"><a href="fruita02.php">查詢所有水果價值小計總和</a></li>
            </ul>
        </div>

        <!-- 會員資料表 -->
        <div class="col-md-4">
            <h3>🧑‍🤝‍🧑 會員資料表</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item"><a href="increase_member.php">會員新增</a></li>
                <li class="list-group-item"><a href="search_member.php">會員查詢</a></li>
                <li class="list-group-item"><a href="delete_member.php">會員刪除</a></li>
                <li class="list-group-item"><a href="fix_member.php">會員修改</a></li>
                <li class="list-group-item"><a href="membera01.php">統計會員人數與平均年齡</a></li>
            </ul>
        </div>

        <!-- 靜止會員資料表 -->
        <div class="col-md-4">
            <h3>⏸️ 靜止會員資料表</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item"><a href="search_S_member.php">靜止會員查詢</a></li>
                <li class="list-group-item"><a href="delete_S_member.php">靜止會員復活</a></li>
                <li class="list-group-item"><a href="fix_S_member.php">靜止會員修改</a></li>
                <li class="list-group-item"><a href="S_membera01.php">統計靜止會員人數與平均年齡</a></li>
            </ul>
        </div>

        <!-- 供應商資料表 -->
        <div class="col-md-4">
            <h3>🏢 供應商資料表</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item"><a href="increase_sup.php">供應商新增</a></li>
                <li class="list-group-item"><a href="search_sup.php">供應商查詢</a></li>
                <li class="list-group-item"><a href="delete_sup.php">供應商刪除</a></li>
                <li class="list-group-item"><a href="fix_sup.php">供應商修改</a></li>
            </ul>
        </div>

        <!-- 水果交易資料表 -->
        <div class="col-md-4">
            <h3>📦 水果交易資料表</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item"><a href="increase_deal.php">交易新增</a></li>
                <li class="list-group-item"><a href="search_deal.php">交易查詢</a></li>
                <li class="list-group-item"><a href="delete_deal.php">交易刪除</a></li>
                <li class="list-group-item"><a href="deala01.php">查詢會員購買水果總金額</a></li>
            </ul>
        </div>
    </div>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
