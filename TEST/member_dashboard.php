<?php
// member_dashboard.php

session_start();

// 檢查是否登入
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php'); // 如果未登入，導向至登入頁面
    exit();
}

$member_id = $_SESSION['member_id'];
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員儀表板</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?fruits') no-repeat center center/cover;
            text-shadow: none; /* 移除陰影 */
        }
        .hero-section h1,
        .hero-section p {
            color: black !important; /* 將文字顏色設為黑色 */
        }
    </style>
</head>
<body>

<!-- 頂部導航欄 -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 會員中心</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">首頁</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">登出</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section text-center py-5">
    <div class="container">
        <h1>歡迎回來，<?php echo htmlspecialchars($member_id); ?>！</h1>
        <p class="lead">在這裡管理您的帳戶與訂單。</p>
        <button class="btn btn-light btn-lg">開始使用</button>
    </div>
</section>

<!-- 功能選單 -->
<section class="container my-5">
    <h2 class="text-center mb-4">📋 功能選單</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="card-icon mb-3">🔍</div>
                    <h5 class="card-title">查詢水果</h5>
                    <p class="card-text">瀏覽我們的最新水果清單。</p>
                    <a href="mema01.php" class="btn btn-success">進入</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="card-icon mb-3">🛒</div>
                    <h5 class="card-title">下訂單</h5>
                    <p class="card-text">立即訂購您喜愛的水果。</p>
                    <a href="mema02.php" class="btn btn-success">進入</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="card-icon mb-3">📦</div>
                    <h5 class="card-title">查詢我的訂單</h5>
                    <p class="card-text">查看您過去的訂單記錄。</p>
                    <a href="mema03.php" class="btn btn-success">進入</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="card-icon mb-3">❌</div>
                    <h5 class="card-title">刪除訂單</h5>
                    <p class="card-text">移除不需要的訂單。</p>
                    <a href="mema04.php" class="btn btn-danger">進入</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="card-icon mb-3">⚙️</div>
                    <h5 class="card-title">修改基本資料</h5>
                    <p class="card-text">更新您的帳戶資訊。</p>
                    <a href="mema05.php" class="btn btn-warning">進入</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
