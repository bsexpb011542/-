<?php
$dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

if (!$dbConnection) {
    die("Connection failed: " . mysqli_connect_error());
}

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
    $discount = 0.95;

    if (!preg_match('/^[A-Z]\d{9}$/', $id_number)) {
        $error_message .= "身分證字號格式錯誤<br>";
    }

    if (!is_numeric($phone)) {
        $error_message .= "電話必須為數字<br>";
    }

    if (!is_numeric($mobile)) {
        $error_message .= "手機號碼必須為數字<br>";
    }

    if ($line_member !== '是' && $line_member !== '不是') {
        $error_message .= "是否加入東海水果公司之Line選項錯誤<br>";
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

    if (empty($error_message)) {
        $sql_insert = "INSERT INTO 會員資料表 (會員身分證字號, 密碼, 會員姓名, 電話, 手機號碼, Email, 是否加入東海水果公司之Line, 住址, 年齡, 照片, 會員折扣)
                       VALUES ('$id_number', '$password', '$name', $phone, $mobile, '$email', '$line_member', '$address', $age, '$photo_name', $discount)";

        if (mysqli_query($dbConnection, $sql_insert)) {
            echo "<div class='alert alert-success'>新增會員資料成功</div>";
        } else {
            echo "<div class='alert alert-danger'>新增會員資料失敗: " . mysqli_error($dbConnection) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>$error_message</div>";
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
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">🍎 東海水果公司</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">首頁</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">登入</a></li>
                    <li class="nav-item"><a class="nav-link" href="Register.php">註冊</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="form-container">
        <h2 class="text-center mb-4">新增會員資料</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="id_number" class="form-label">會員身分證字號</label>
                <input type="text" class="form-control" name="id_number" pattern="[A-Z]\d{9}" title="請輸入正確格式，例如：A123456789" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">密碼</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">會員姓名</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">電話</label>
                <input type="text" class="form-control" name="phone" pattern="\d+" title="請輸入數字" required>
            </div>

            <div class="mb-3">
                <label for="mobile" class="form-label">手機號碼</label>
                <input type="text" class="form-control" name="mobile" pattern="\d+" title="請輸入數字" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="line_member" class="form-label">是否加入東海水果公司之Line</label>
                <select name="line_member" class="form-control" required>
                    <option value="是">是</option>
                    <option value="不是">不是</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">住址</label>
                <input type="text" class="form-control" name="address" required>
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">年齡</label>
                <input type="number" class="form-control" name="age" max="9999" required>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">照片</label>
                <input type="file" class="form-control" name="photo" accept="image/*" required>
            </div>

            <div class="mb-3 text-center">
                <input type="submit" name="add_member" class="btn btn-success btn-lg" value="新增會員">
            </div>
        </form>
    </div>

    <?php include_once('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>