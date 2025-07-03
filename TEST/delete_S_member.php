<?php
// delete_S_member.php

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

// 處理復活靜止會員
if (isset($_POST['revive_member'])) {
    $revive_member_id = strtoupper($_POST['revive_member_id']);

    if (preg_match('/^[A-Z]\d{9}$/', $revive_member_id)) {
        $check_query = "SELECT * FROM 靜止會員資料表 WHERE 會員身分證字號 = '$revive_member_id'";
        $check_result = mysqli_query($dbConnection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $row = mysqli_fetch_assoc($check_result);

            // 將資料轉移到會員資料表
            $insert_query = "INSERT INTO 會員資料表 (會員身分證字號, 密碼, 會員姓名, 電話, 手機號碼, Email, 是否加入東海水果公司之Line, 住址, 年齡, 照片, 會員折扣)
                             VALUES ('{$row['會員身分證字號']}', '{$row['密碼']}', '{$row['會員姓名']}', '{$row['電話']}', '{$row['手機號碼']}', '{$row['Email']}', '{$row['是否加入東海水果公司之Line']}', '{$row['住址']}', '{$row['年齡']}', '{$row['照片']}', '{$row['會員折扣']}')";

            if (mysqli_query($dbConnection, $insert_query)) {
                $delete_query = "DELETE FROM 靜止會員資料表 WHERE 會員身分證字號 = '$revive_member_id'";
                if (mysqli_query($dbConnection, $delete_query)) {
                    $success_message = "靜止會員已成功復活，並轉移至會員資料表。";
                } else {
                    $error_message = "刪除靜止會員資料失敗: " . mysqli_error($dbConnection);
                }
            } else {
                $error_message = "轉移至會員資料表失敗: " . mysqli_error($dbConnection);
            }
        } else {
            $error_message = "該靜止會員不存在。";
        }
    } else {
        $error_message = "會員身分證字號格式錯誤，請輸入正確格式 (例如：A123456789)。";
    }
}

// 查詢所有靜止會員
$sql_all_inactive_members = "SELECT * FROM 靜止會員資料表";
$all_inactive_members_result = mysqli_query($dbConnection, $sql_all_inactive_members);

// 關閉資料庫連接
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>靜止會員復活</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?team,people') no-repeat center center/cover;
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
<nav class="navbar navbar-expand-lg navbar-dark bg-warning">
    <div class="container">
        <a class="navbar-brand" href="#">🔄 靜止會員復活</a>
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
        <h1>靜止會員復活</h1>
        <p class="lead">將靜止會員資料恢復到會員資料表。</p>
    </div>
</section>

<!-- 復活會員表單 -->
<section class="container my-5">
    <h3 class="text-center mb-4">🔄 復活靜止會員</h3>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success text-center"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="post" class="d-flex justify-content-center">
        <input type="text" name="revive_member_id" class="form-control w-50 me-2" placeholder="輸入會員身分證字號" pattern="[A-Z]\d{9}" title="請輸入正確格式，例如：A123456789" required>
        <button type="submit" name="revive_member" class="btn btn-warning">復活會員</button>
    </form>
</section>

<!-- 所有靜止會員資料 -->
<section class="container my-5">
    <h4 class="text-center">📋 所有靜止會員資料：</h4>
    <table class="table table-bordered table-hover text-center align-middle mt-3">
        <thead class="table-warning">
            <tr>
                <th>會員身分證字號</th>
                <th>會員姓名</th>
                <th>Email</th>
                <th>電話</th>
                <th>年齡</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($all_inactive_members_result)): ?>
                <tr>
                    <td><?php echo $row['會員身分證字號']; ?></td>
                    <td><?php echo $row['會員姓名']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['電話']; ?></td>
                    <td><?php echo $row['年齡']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<?php include_once('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
