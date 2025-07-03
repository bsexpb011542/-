<?php
// mema03.php

session_start();
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit();
}

$member_id = $_SESSION['member_id'];

// 資料庫連接
$dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// 檢查連接是否成功
if (!$dbConnection) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 查詢水果交易資料
$sql = "SELECT * FROM 水果交易資料表 
        WHERE 會員身分證字號 = '$member_id' AND 水果交易隱藏 = 0";
$result = mysqli_query($dbConnection, $sql);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查詢我的訂單</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?fruits') no-repeat center center/cover;
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        .hero-section h1 {
            color: black !important;
        }
        table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<!-- 導覽列 -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 我的訂單</a>
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
        <h1>查詢我的訂單</h1>
        <p class="lead">查看您的歷史水果訂單記錄。</p>
    </div>
</section>

<!-- 訂單列表 -->
<section class="container my-5">
    <h3 class="text-center mb-4">📋 我的訂單清單</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-success">
                <tr>
                    <th>交易編號</th>
                    <th>水果編號</th>
                    <th>水果名稱</th>
                    <th>購買數量</th>
                    <th>出售單價</th>
                    <th>總金額</th>
                    <th>折扣後金額</th>
                    <th>交易日期</th>
                    <th>預計交運日期</th>
                    <th>實際交運日期</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row["交易編號"]; ?></td>
                            <td><?php echo $row["水果編號"]; ?></td>
                            <td><?php echo $row["水果名稱"]; ?></td>
                            <td><?php echo $row["購買數量"]; ?></td>
                            <td><?php echo $row["出售單價"]; ?></td>
                            <td><?php echo $row["總金額"]; ?></td>
                            <td><?php echo $row["折扣後金額"]; ?></td>
                            <td><?php echo $row["交易日期"]; ?></td>
                            <td><?php echo $row["預計交運日期"]; ?></td>
                            <td><?php echo $row["實際交運日期"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-danger">查無訂單資料。</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
