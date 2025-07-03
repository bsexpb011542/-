<?php
// increase_fruit.php

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

// 處理新增水果邏輯
if (isset($_POST['add_fruit'])) {
    $fruit_id = $_POST['fruit_id'];
    $fruit_name = $_POST['fruit_name'];
    $supplier_name = $_POST['supplier_name'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $unit_price = $_POST['unit_price'];
    $storage_location = $_POST['storage_location'];
    $purchase_date = $_POST['purchase_date'];
    $promotion_start_date = $_POST['promotion_start_date'];
    $expiration_date = $_POST['expiration_date'];

    if (strtotime($expiration_date) >= strtotime($promotion_start_date) && strtotime($promotion_start_date) >= strtotime($purchase_date)) {
        if (preg_match('/^\d{2}-\d{3}-\d{3}-\d{2}$/', $fruit_id)) {
            if (is_numeric($quantity) && $quantity > 0 && intval($quantity) == $quantity) {
                if (is_numeric($unit_price) && $unit_price > 0) {
                    $sql_check_duplicate = "SELECT COUNT(*) AS count FROM 水果資料表 WHERE 水果編號 = '$fruit_id'";
                    $result_check_duplicate = mysqli_query($dbConnection, $sql_check_duplicate);
                    $row_check_duplicate = mysqli_fetch_assoc($result_check_duplicate);

                    if ($row_check_duplicate['count'] == 0) {
                        $subtotal = $quantity * $unit_price;

                        $sql_insert = "INSERT INTO 水果資料表 (水果編號, 水果名稱, 水果供應商名稱, 公司內現有數量, 單位, 進貨單價, 現有價值小計, 公司內存放位置, 進貨日期, 開始促銷日期, 該丟棄之日期)
                                       VALUES ('$fruit_id', '$fruit_name', '$supplier_name', $quantity, '$unit', $unit_price, $subtotal, '$storage_location', '$purchase_date', '$promotion_start_date', '$expiration_date')";

                        if (mysqli_query($dbConnection, $sql_insert)) {
                            $success_message = "新增水果資料成功！";
                        } else {
                            $error_message = "新增水果資料失敗: " . mysqli_error($dbConnection);
                        }
                    } else {
                        $error_message = "水果編號重複，請輸入不同的水果編號";
                    }
                } else {
                    $error_message = "進貨單價必須為正數";
                }
            } else {
                $error_message = "數量必須為正整數";
            }
        } else {
            $error_message = "水果編號格式錯誤，請輸入正確格式（12-345-678-90）";
        }
    } else {
        $error_message = "日期順序錯誤，請確保日期順序為：進貨日期 <= 開始促銷日期 <= 該丟棄之日期";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增水果資料</title>
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
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 新增水果</a>
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
        <h1>新增水果資料</h1>
        <p class="lead">請填寫以下資料完成水果資訊的新增。</p>
    </div>
</section>

<!-- 表單區塊 -->
<section class="container my-5">
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post" class="p-4 border rounded shadow-sm">
        <label>水果編號</label>
        <input type="text" name="fruit_id" class="form-control" pattern="\d{2}-\d{3}-\d{3}-\d{2}" required>
        <label>水果名稱</label>
        <input type="text" name="fruit_name" class="form-control" required>
        <button type="submit" name="add_fruit" class="btn btn-primary w-100 mt-3">新增水果</button>
    </form>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
