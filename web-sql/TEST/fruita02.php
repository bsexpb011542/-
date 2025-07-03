<?php
// fruita02.php

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

// 查詢水果總數量與總價值
$sql = "SELECT SUM(公司內現有數量) AS 總數量, SUM(公司內現有數量 * 進貨單價) AS 總價值小計 
        FROM 水果資料表 
        WHERE 水果隱藏 = 0";
$result = mysqli_query($dbConnection, $sql);
$row = mysqli_fetch_assoc($result);

// 關閉資料庫連接
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查詢所有水果現有價值小計總和</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?fruit,basket') no-repeat center center/cover;
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
        <a class="navbar-brand" href="#">📊 水果總價值查詢</a>
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
        <h1>查詢所有水果現有數量與價值總和</h1>
        <p class="lead">顯示公司內所有水果的現有數量與總價值小計。</p>
    </div>
</section>

<!-- 查詢結果顯示 -->
<section class="container my-5">
    <h3 class="text-center mb-4">📊 查詢結果</h3>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header bg-success text-white">
                    <h5>水果總量與價值統計</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong>總數量：</strong> <?php echo number_format($row['總數量']); ?> 件</p>
                    <p class="card-text"><strong>總價值小計：</strong> $<?php echo number_format($row['總價值小計'], 2); ?></p>
                </div>
                <div class="card-footer text-muted">
                    查詢時間：<?php echo date('Y-m-d H:i:s'); ?>
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
