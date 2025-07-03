<?php
// search_fruit.php

session_start();
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit();
}

// 資料庫連接
$dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// 檢查連接是否成功
if (!$dbConnection) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 處理查詢水果資料
$search_option = isset($_POST['search_option']) ? $_POST['search_option'] : '水果名稱';
$search_term = isset($_POST['search_term']) ? mysqli_real_escape_string($dbConnection, $_POST['search_term']) : '';
$search_result = null;

if (isset($_POST['search']) && !empty($search_term)) {
    $sql_search = "SELECT * FROM 水果資料表 WHERE $search_option = '$search_term' AND 水果隱藏 = 0";
    $search_result = mysqli_query($dbConnection, $sql_search);
}

// 查詢所有水果資料
$sql_all_fruits = "SELECT * FROM 水果資料表 WHERE 水果隱藏 = 0";
$all_fruits_result = mysqli_query($dbConnection, $sql_all_fruits);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>水果資料查詢</title>
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
        <a class="navbar-brand" href="#">🍎 水果訂貨平台 - 水果查詢</a>
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
        <h1>水果資料查詢</h1>
        <p class="lead">輸入條件以查詢特定水果資料，或查看所有水果資訊。</p>
    </div>
</section>

<!-- 查詢表單 -->
<section class="container my-5">
    <h3 class="text-center mb-4">📋 查詢水果</h3>
    <form method="post" class="d-flex justify-content-center mb-4">
        <select name="search_option" class="form-select w-25 me-2">
            <option value="水果編號">水果編號</option>
            <option value="水果名稱">水果名稱</option>
        </select>
        <input type="text" name="search_term" class="form-control w-50 me-2" placeholder="輸入水果編號或名稱" value="<?php echo htmlspecialchars($search_term); ?>" required>
        <button type="submit" name="search" class="btn btn-primary">查詢</button>
    </form>

    <?php if (isset($_POST['search']) && $search_result): ?>
        <h4 class="text-center">🔍 查詢結果：</h4>
        <?php if (mysqli_num_rows($search_result) > 0): ?>
            <table class="table table-bordered table-hover text-center align-middle mt-3">
                <thead class="table-success">
                    <tr>
                        <th>水果編號</th>
                        <th>水果名稱</th>
                        <th>水果供應商名稱</th>
                        <th>現有數量</th>
                        <th>單位</th>
                        <th>進貨單價</th>
                        <th>現有價值小計</th>
                        <th>存放位置</th>
                        <th>進貨日期</th>
                        <th>促銷日期</th>
                        <th>丟棄日期</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($search_result)): ?>
                        <tr>
                            <td><?php echo $row['水果編號']; ?></td>
                            <td><?php echo $row['水果名稱']; ?></td>
                            <td><?php echo $row['水果供應商名稱']; ?></td>
                            <td><?php echo $row['公司內現有數量']; ?></td>
                            <td><?php echo $row['單位']; ?></td>
                            <td><?php echo $row['進貨單價']; ?></td>
                            <td><?php echo $row['現有價值小計']; ?></td>
                            <td><?php echo $row['公司內存放位置']; ?></td>
                            <td><?php echo $row['進貨日期']; ?></td>
                            <td><?php echo $row['開始促銷日期']; ?></td>
                            <td><?php echo $row['該丟棄之日期']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center">查無資料</div>
        <?php endif; ?>
    <?php endif; ?>
</section>

<!-- 所有水果資料 -->
<section class="container my-5">
    <h4 class="text-center">📋 所有水果資料：</h4>
    <table class="table table-bordered table-hover text-center align-middle mt-3">
        <thead class="table-success">
            <tr>
                <th>水果編號</th>
                <th>水果名稱</th>
                <th>現有數量</th>
                <th>單位</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($all_fruits_result)): ?>
                <tr>
                    <td><?php echo $row['水果編號']; ?></td>
                    <td><?php echo $row['水果名稱']; ?></td>
                    <td><?php echo $row['公司內現有數量']; ?></td>
                    <td><?php echo $row['單位']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<?php include_once('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
