<?php
// mema01.php

session_start();
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit();
}

$member_id = $_SESSION['member_id'];

// 初始化變數
$search_term = "";
$hidden_condition = "";

// 資料庫連接
$dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// 檢查連接是否成功
if (!$dbConnection) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 處理使用者輸入
if (isset($_POST['search'])) {
    $search_term = mysqli_real_escape_string($dbConnection, $_POST['search_term']);
    $hidden_condition = " AND 水果隱藏 = 0";
}

// 查詢水果資料
$sql_search_fruit = "SELECT 水果編號, 水果名稱, 公司內現有數量, 單位, 進貨單價, 進貨單價*3 AS 售價 
                     FROM 水果資料表
                     WHERE (水果編號 = '$search_term' OR 水果名稱 = '$search_term') $hidden_condition";
$result_search_fruit = mysqli_query($dbConnection, $sql_search_fruit);

// 查詢所有水果資料
$sql_all_fruits = "SELECT 水果編號, 水果名稱, 公司內現有數量, 單位, 進貨單價, 進貨單價*3 AS 售價 
                   FROM 水果資料表 
                   WHERE 水果隱藏 = 0";
$result_all_fruits = mysqli_query($dbConnection, $sql_all_fruits);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查詢水果資料</title>
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
        .hero-section p {
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

<!-- 頂部導航欄 -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 查詢水果</a>
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

<!-- Hero Section -->
<section class="hero-section text-center py-5">
    <div class="container">
        <h1>查詢水果資料</h1>
        <p class="lead">您可以輸入水果編號或名稱進行查詢。</p>
    </div>
</section>

<!-- 查詢表單 -->
<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="" method="post" class="d-flex mb-4">
                <input type="text" name="search_term" class="form-control me-2" placeholder="輸入水果編號或名稱" value="<?php echo htmlspecialchars($search_term); ?>">
                <button type="submit" name="search" class="btn btn-primary">查詢</button>
            </form>
        </div>
    </div>

    <!-- 查詢結果 -->
    <?php if (isset($_POST['search'])): ?>
        <?php if (mysqli_num_rows($result_search_fruit) > 0): ?>
            <h3 class="text-center">🔍 查詢結果：</h3>
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-success">
                    <tr>
                        <th>水果編號</th>
                        <th>水果名稱</th>
                        <th>現有數量</th>
                        <th>單位</th>
                        <th>售價</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_search_fruit)): ?>
                        <tr>
                            <td><?php echo $row["水果編號"]; ?></td>
                            <td><?php echo $row["水果名稱"]; ?></td>
                            <td><?php echo $row["公司內現有數量"]; ?></td>
                            <td><?php echo $row["單位"]; ?></td>
                            <td><?php echo $row["售價"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-danger">查無資料。</p>
        <?php endif; ?>
    <?php else: ?>
        <h3 class="text-center">📋 所有水果資料：</h3>
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-success">
                <tr>
                    <th>水果編號</th>
                    <th>水果名稱</th>
                    <th>現有數量</th>
                    <th>單位</th>
                    <th>售價</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_all_fruits)): ?>
                    <tr>
                        <td><?php echo $row["水果編號"]; ?></td>
                        <td><?php echo $row["水果名稱"]; ?></td>
                        <td><?php echo $row["公司內現有數量"]; ?></td>
                        <td><?php echo $row["單位"]; ?></td>
                        <td><?php echo $row["售價"]; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
