<?php
// mema05.php

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

// 查詢會員資料
$sql_select_member = "SELECT * FROM 會員資料表 WHERE 會員身分證字號 = '$member_id'";
$result_select_member = mysqli_query($dbConnection, $sql_select_member);

// 檢查是否有找到會員資料
if (mysqli_num_rows($result_select_member) > 0) {
    $member_data = mysqli_fetch_assoc($result_select_member);

    if (isset($_POST['update'])) {
        $password = mysqli_real_escape_string($dbConnection, $_POST['password']);
        $name = mysqli_real_escape_string($dbConnection, $_POST['name']);
        $phone = mysqli_real_escape_string($dbConnection, $_POST['phone']);
        $mobile = mysqli_real_escape_string($dbConnection, $_POST['mobile']);
        $email = mysqli_real_escape_string($dbConnection, $_POST['email']);
        $line = mysqli_real_escape_string($dbConnection, $_POST['line']);
        $address = mysqli_real_escape_string($dbConnection, $_POST['address']);
        $age = mysqli_real_escape_string($dbConnection, $_POST['age']);

        $sql_update_member = "UPDATE 會員資料表 
                              SET 密碼 = '$password', 會員姓名 = '$name', 電話 = '$phone', 手機號碼 = '$mobile',
                                  Email = '$email', 是否加入東海水果公司之Line = '$line', 住址 = '$address',
                                  年齡 = '$age'
                              WHERE 會員身分證字號 = '$member_id'";
        if (mysqli_query($dbConnection, $sql_update_member)) {
            $success_message = "資料更新成功！";
        } else {
            $error_message = "資料更新失敗: " . mysqli_error($dbConnection);
        }
    }
} else {
    $error_message = "查無此會員資料";
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改基本資料</title>
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
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 修改基本資料</a>
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
        <h1>修改基本資料</h1>
        <p class="lead">請更新您的個人資料，確保資訊正確。</p>
    </div>
</section>

<!-- 表單區塊 -->
<section class="container my-5">
    <h3 class="text-center mb-4">📋 基本資料</h3>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post" class="p-4 border rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">密碼</label>
            <input type="password" name="password" class="form-control" value="<?php echo htmlspecialchars($member_data['密碼']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">姓名</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($member_data['會員姓名']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">電話</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($member_data['電話']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">手機號碼</label>
            <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($member_data['手機號碼']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($member_data['Email']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">地址</label>
            <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($member_data['住址']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">年齡</label>
            <input type="text" name="age" class="form-control" value="<?php echo htmlspecialchars($member_data['年齡']); ?>">
        </div>
        <button type="submit" name="update" class="btn btn-primary w-100">更新資料</button>
    </form>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
