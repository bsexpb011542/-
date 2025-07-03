<?php
// membera01.php

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

// 統計會員人數
$sql_member_count = "SELECT COUNT(*) AS member_count FROM 會員資料表";
$result_member_count = mysqli_query($dbConnection, $sql_member_count);
$row_member_count = mysqli_fetch_assoc($result_member_count);
$member_count = $row_member_count['member_count'];

// 統計會員平均年齡
$sql_avg_age = "SELECT AVG(年齡) AS avg_age FROM 會員資料表";
$result_avg_age = mysqli_query($dbConnection, $sql_avg_age);
$row_avg_age = mysqli_fetch_assoc($result_avg_age);
$avg_age = round($row_avg_age['avg_age']); // 四捨五入取整數

// 關閉資料庫連接
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員統計資訊</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?people,team') no-repeat center center/cover;
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
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">🧑‍🤝‍🧑 會員統計資訊</a>
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
        <h1>會員統計資訊</h1>
        <p class="lead">快速查看會員人數與平均年齡統計數據。</p>
    </div>
</section>

<!-- 統計結果 -->
<section class="container my-5">
    <h3 class="text-center mb-4">📊 會員統計結果</h3>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header bg-primary text-white">
                    <h5>會員總人數</h5>
                </div>
                <div class="card-body">
                    <h1 class="display-4"><?php echo number_format($member_count); ?></h1>
                    <p class="card-text">人</p>
                </div>
                <div class="card-footer text-muted">
                    統計時間：<?php echo date('Y-m-d H:i:s'); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header bg-success text-white">
                    <h5>會員平均年齡</h5>
                </div>
                <div class="card-body">
                    <h1 class="display-4"><?php echo $avg_age; ?></h1>
                    <p class="card-text">歲</p>
                </div>
                <div class="card-footer text-muted">
                    統計時間：<?php echo date('Y-m-d H:i:s'); ?>
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
