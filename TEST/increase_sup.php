<?php
// increase_sup.php

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

// 新增供應商邏輯
if (isset($_POST['add_supplier'])) {
    $supplier_id = mysqli_real_escape_string($dbConnection, $_POST['supplier_id']);
    $supplier_name = mysqli_real_escape_string($dbConnection, $_POST['supplier_name']);
    $phone = mysqli_real_escape_string($dbConnection, $_POST['phone']);
    $email = mysqli_real_escape_string($dbConnection, $_POST['email']);
    $address = mysqli_real_escape_string($dbConnection, $_POST['address']);
    $contact_person = mysqli_real_escape_string($dbConnection, $_POST['contact_person']);

    if (
        preg_match('/^\d{8}$/', $supplier_id) &&
        mb_strlen($supplier_name, 'utf-8') <= 12 &&
        filter_var($email, FILTER_VALIDATE_EMAIL) && mb_strlen($email, 'utf-8') <= 36 &&
        mb_strlen($address, 'utf-8') <= 60 &&
        mb_strlen($contact_person, 'utf-8') <= 12
    ) {
        $insert_query = "INSERT INTO 供應商資料表 (供應商統一編號, 水果供應商名稱, 電話, Email, 住址, 負責人姓名, 供應商隱藏)
                         VALUES ('$supplier_id', '$supplier_name', '$phone', '$email', '$address', '$contact_person', 0)";

        if (mysqli_query($dbConnection, $insert_query)) {
            $success_message = "新增供應商成功";
        } else {
            $error_message = "新增供應商失敗: " . mysqli_error($dbConnection);
        }
    } else {
        $error_message = "請確保輸入資料符合規範且不為空值";
    }
}

// 顯示供應商資料
$display_query = "SELECT 供應商統一編號, 水果供應商名稱, 電話, Email, 住址, 負責人姓名 
                  FROM 供應商資料表 
                  WHERE 供應商隱藏 = 0";
$display_result = mysqli_query($dbConnection, $display_query);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增供應商</title>
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
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 新增供應商</a>
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
        <h1>新增水果供應商</h1>
        <p class="lead">請填寫以下資訊，完成新增供應商。</p>
    </div>
</section>

<!-- 表單區塊 -->
<section class="container my-5">
    <h3 class="text-center mb-4">📋 供應商資料表單</h3>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post" class="p-4 border rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">供應商統一編號</label>
            <input type="text" name="supplier_id" class="form-control" pattern="\d{8}" title="請輸入八碼數字" required>
        </div>
        <div class="mb-3">
            <label class="form-label">供應商名稱</label>
            <input type="text" name="supplier_name" class="form-control" maxlength="12" required>
        </div>
        <div class="mb-3">
            <label class="form-label">電話</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" maxlength="36" required>
        </div>
        <div class="mb-3">
            <label class="form-label">住址</label>
            <input type="text" name="address" class="form-control" maxlength="60" required>
        </div>
        <div class="mb-3">
            <label class="form-label">負責人姓名</label>
            <input type="text" name="contact_person" class="form-control" maxlength="12" required>
        </div>
        <button type="submit" name="add_supplier" class="btn btn-primary w-100">新增供應商</button>
    </form>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
