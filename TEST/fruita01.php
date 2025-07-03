<?php
// fruita01.php

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

// 初始化變數
$fruit_name_to_query = isset($_POST['fruit_name_to_query']) ? mysqli_real_escape_string($dbConnection, $_POST['fruit_name_to_query']) : '';
$search_result = null;

if (isset($_POST['query_fruit']) && !empty($fruit_name_to_query)) {
    $sql = "SELECT 水果名稱, 公司內現有數量, 進貨單價, 公司內現有數量 * 進貨單價 AS 現有價值小計
            FROM 水果資料表
            WHERE 水果名稱 = '$fruit_name_to_query' AND 水果隱藏 = 0";
    $search_result = mysqli_query($dbConnection, $sql);
}

// 關閉連接
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查詢水果現有數量與價值小計</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?fruit') no-repeat center center/cover;
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
        <a class="navbar-brand" href="#">🍇 查詢水果數量與價值</a>
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
        <h1>查詢水果現有數量與價值小計</h1>
        <p class="lead">輸入水果名稱以查看其現有數量與價值小計。</p>
    </div>
</section>

<!-- 查詢表單 -->
<section class="container my-5">
    <h3 class="text-center mb-4">🔍 查詢水果</h3>
    <form method="post" class="d-flex justify-content-center mb-4">
        <input type="text" name="fruit_name_to_query" class="form-control w-50 me-2" placeholder="輸入水果名稱" value="<?php echo htmlspecialchars($fruit_name_to_query); ?>" required>
        <button type="submit" name="query_fruit" class="btn btn-primary">查詢</button>
    </form>

    <?php if (isset($_POST['query_fruit'])): ?>
        <h4 class="text-center">🔍 查詢結果：</h4>
        <?php if ($search_result && mysqli_num_rows($search_result) > 0): ?>
            <table class="table table-bordered table-hover text-center align-middle mt-3">
                <thead class="table-success">
                    <tr>
                        <th>水果名稱</th>
                        <th>公司內現有數量</th>
                        <th>進貨單價</th>
                        <th>現有價值小計</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($search_result)): ?>
                        <tr>
                            <td><?php echo $row['水果名稱']; ?></td>
                            <td><?php echo $row['公司內現有數量']; ?></td>
                            <td><?php echo $row['進貨單價']; ?></td>
                            <td><?php echo $row['現有價值小計']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center">查無資料，請確認水果名稱是否正確。</div>
        <?php endif; ?>
    <?php endif; ?>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
