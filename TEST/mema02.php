<?php
// mema02.php

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

// 處理使用者輸入
if (isset($_POST['add_transaction'])) {
    $fruit_id = $_POST['fruit_id'];
    $member_id = $_POST['member_id'];
    $purchase_quantity = $_POST['purchase_quantity'];

    $sql_get_fruit_data = "SELECT * FROM 水果資料表 WHERE 水果編號 = '$fruit_id'";
    $result_get_fruit_data = mysqli_query($dbConnection, $sql_get_fruit_data);

    if ($result_get_fruit_data && mysqli_num_rows($result_get_fruit_data) > 0) {
        $row_fruit = mysqli_fetch_assoc($result_get_fruit_data);
        $fruit_name = $row_fruit['水果名稱'];
        $supplier_name = $row_fruit['水果供應商名稱'];
        $purchase_price = $row_fruit['進貨單價'];

        $total_amount = $purchase_quantity * $purchase_price;

        $sql_get_member_data = "SELECT * FROM 會員資料表 WHERE 會員身分證字號 = '$member_id'";
        $result_get_member_data = mysqli_query($dbConnection, $sql_get_member_data);

        if ($result_get_member_data && mysqli_num_rows($result_get_member_data) > 0) {
            $row_member = mysqli_fetch_assoc($result_get_member_data);
            $discount = $row_member['會員折扣'];
            $discounted_amount = $total_amount * $discount;

            $updated_quantity = $row_fruit['公司內現有數量'] - $purchase_quantity;

            if ($updated_quantity >= 0) {
                $sql_update_quantity = "UPDATE 水果資料表 SET 公司內現有數量 = $updated_quantity WHERE 水果編號 = '$fruit_id'";

                if (mysqli_query($dbConnection, $sql_update_quantity)) {
                    $sql_insert_transaction = "INSERT INTO 水果交易資料表 (水果編號, 水果名稱, 水果供應商名稱, 會員身分證字號, 購買數量, 出售單價, 總金額, 折扣後金額, 交易日期, 預計交運日期, 實際交運日期)
                        VALUES ('$fruit_id', '$fruit_name', '$supplier_name', '$member_id', $purchase_quantity, $purchase_price, $total_amount, $discounted_amount, NOW(), DATE_ADD(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL 1 DAY))";

                    if (mysqli_query($dbConnection, $sql_insert_transaction)) {
                        $transaction_id = mysqli_insert_id($dbConnection);
                        $success_message = "交易成功！";
                    } else {
                        $error_message = "新增交易資料失敗: " . mysqli_error($dbConnection);
                    }
                } else {
                    $error_message = "更新水果數量失敗: " . mysqli_error($dbConnection);
                }
            } else {
                $error_message = "水果數量不足，無法完成交易";
            }
        } else {
            $error_message = "找不到對應的會員資料";
        }
    } else {
        $error_message = "找不到對應的水果資料";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增水果訂單</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?fruits') no-repeat center center/cover;
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
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 下訂單</a>
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
        <h1>新增水果訂單</h1>
        <p class="lead">請填寫以下資料完成水果訂購。</p>
    </div>
</section>

<!-- 訂單表單 -->
<section class="container my-5">
    <form method="post" class="p-4 border rounded shadow-sm">
        <div class="mb-3">
            <label for="fruit_id" class="form-label">水果編號：</label>
            <input type="text" name="fruit_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="purchase_quantity" class="form-label">購買數量：</label>
            <input type="number" name="purchase_quantity" class="form-control" min="1" required>
        </div>
        <button type="submit" name="add_transaction" class="btn btn-success w-100">成立訂單</button>
    </form>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success mt-4"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger mt-4"><?php echo $error_message; ?></div>
    <?php endif; ?>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
