<?php
// mema04.php

session_start();
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit();
}

$member_id = $_SESSION['member_id'];

// 資料庫連接
$dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// 檢查資料庫連接是否成功
if (!$dbConnection) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 查詢水果交易資料
$sql = "SELECT * FROM 水果交易資料表 
        WHERE 會員身分證字號 = '$member_id' AND 水果交易隱藏 = 0";
$result = mysqli_query($dbConnection, $sql);

// 處理刪除請求
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hidden'])) {
    $hidden_ids = $_POST['hidden'];
    foreach ($hidden_ids as $transaction_id) {
        $transaction_id = mysqli_real_escape_string($dbConnection, $transaction_id);
        $sql_hide_transaction = "UPDATE 水果交易資料表 SET 水果交易隱藏 = 1 WHERE 交易編號 = '$transaction_id' AND 會員身分證字號 = '$member_id'";
        mysqli_query($dbConnection, $sql_hide_transaction);
    }
    $success_message = "所選交易已成功刪除。";
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>刪除水果訂單</title>
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
    </style>
</head>
<body>

<!-- 導覽列 -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 刪除訂單</a>
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
        <h1>刪除水果訂單</h1>
        <p class="lead">選擇您要刪除的訂單，並確認刪除。</p>
    </div>
</section>

<!-- 訂單列表 -->
<section class="container my-5">
    <h3 class="text-center mb-4">📋 我的水果訂單</h3>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-success">
                    <tr>
                        <th>選擇</th>
                        <th>交易編號</th>
                        <th>水果編號</th>
                        <th>水果名稱</th>
                        <th>購買數量</th>
                        <th>交易日期</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><input type="checkbox" name="hidden[]" value="<?php echo $row['交易編號']; ?>"></td>
                                <td><?php echo $row['交易編號']; ?></td>
                                <td><?php echo $row['水果編號']; ?></td>
                                <td><?php echo $row['水果名稱']; ?></td>
                                <td><?php echo $row['購買數量']; ?></td>
                                <td><?php echo $row['交易日期']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-danger">目前沒有可刪除的訂單。</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-danger w-100 mt-3">確認刪除</button>
    </form>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
