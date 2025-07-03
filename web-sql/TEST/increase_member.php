<?php
// increase_member.php

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

// 新增會員邏輯
$error_message = "";

if (isset($_POST['add_member'])) {
    $id_number = strtoupper($_POST['id_number']);
    $password = $_POST['password'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $line_member = $_POST['line_member'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $discount = $_POST['discount'];

    // 檢查格式
    if (!preg_match('/^[A-Z]\d{9}$/', $id_number)) {
        $error_message .= "身分證字號格式錯誤<br>";
    }

    if (!is_numeric($phone)) {
        $error_message .= "電話必須為數字<br>";
    }

    if (!is_numeric($mobile)) {
        $error_message .= "手機號碼必須為數字<br>";
    }

    if (!is_numeric($age) || $age > 9999) {
        $error_message .= "年齡格式錯誤<br>";
    }

    if (!is_numeric($discount) || $discount < 0 || $discount > 1) {
        $error_message .= "會員折扣範圍錯誤<br>";
    }

    if (!empty($_FILES['photo']['name'])) {
        $upload_path = "uploads/";
        $photo_name = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        move_uploaded_file($photo_tmp, $upload_path . $photo_name);
    } else {
        $error_message .= "請上傳照片<br>";
    }

    // 如果沒有錯誤，執行新增
    if (empty($error_message)) {
        $sql_insert = "INSERT INTO 會員資料表 (會員身分證字號, 密碼, 會員姓名, 電話, 手機號碼, Email, 是否加入東海水果公司之Line, 住址, 年齡, 照片, 會員折扣)
                       VALUES ('$id_number', '$password', '$name', '$phone', '$mobile', '$email', '$line_member', '$address', $age, '$photo_name', $discount)";

        if (mysqli_query($dbConnection, $sql_insert)) {
            $success_message = "新增會員資料成功";
        } else {
            $error_message = "新增會員資料失敗: " . mysqli_error($dbConnection);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增會員資料</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?people') no-repeat center center/cover;
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
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 新增會員</a>
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
        <h1>新增會員資料</h1>
        <p class="lead">請填寫以下資訊以完成會員註冊。</p>
    </div>
</section>

<!-- 表單區塊 -->
<section class="container my-5">
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php elseif (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="p-4 border rounded shadow-sm">
        <div class="mb-3">
            <label>會員身分證字號</label>
            <input type="text" name="id_number" class="form-control" pattern="[A-Z]\d{9}" required>
        </div>
        <div class="mb-3">
            <label>密碼</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>姓名</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" name="add_member" class="btn btn-primary w-100">新增會員</button>
    </form>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
