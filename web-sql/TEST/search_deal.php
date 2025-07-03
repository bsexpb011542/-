<?php
// search_deal.php

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

// 初始化查詢條件
$search_option = isset($_POST['search_option']) ? $_POST['search_option'] : '水果編號';
$search_term = isset($_POST['search_term']) ? mysqli_real_escape_string($dbConnection, $_POST['search_term']) : '';
$search_result = null;

if (isset($_POST['search']) && !empty($search_term)) {
    if ($search_option === '水果編號') {
        $sql_search = "SELECT * FROM 水果交易資料表 WHERE 水果編號 = '$search_term'";
    } elseif ($search_option === '會員身分證字號' && preg_match('/^[A-Z]\d{9}$/', $search_term)) {
        $sql_search = "SELECT * FROM 水果交易資料表 WHERE 會員身分證字號 = '$search_term'";
    } else {
        $error_message = "查詢條件錯誤，請確認輸入格式。";
    }

    if (isset($sql_search)) {
        $search_result = mysqli_query($dbConnection, $sql_search);
    }
}

// 查詢所有交易資料
$sql_all_deals = "SELECT * FROM 水果交易資料表";
$all_deals_result = mysqli_query($dbConnection, $sql_all_deals);

// 關閉資料庫連接
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>水果交易查詢</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?market,fruit') no-repeat center center/cover;
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
        <a class="navbar-brand" href="#">📦 水果交易查詢</a>
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
        <h1>水果交易資料查詢</h1>
        <p class="lead">查詢特定水果或會員的交易資料，或查看所有交易紀錄。</p>
    </div>
</section>

<!-- 查詢表單 -->
<section class="container my-5">
    <h3 class="text-center mb-4">🔍 查詢交易資料</h3>
    <form method="post" class="d-flex justify-content-center mb-4">
        <select name="search_option" class="form-select w-25 me-2">
            <option value="水果編號" <?php echo $search_option == '水果編號' ? 'selected' : ''; ?>>水果編號</option>
            <option value="會員身分證字號" <?php echo $search_option == '會員身分證字號' ? 'selected' : ''; ?>>會員身分證字號</option>
        </select>
        <input type="text" name="search_term" class="form-control w-50 me-2" placeholder="輸入水果編號或會員身分證字號" value="<?php echo htmlspecialchars($search_term); ?>" required>
        <button type="submit" name="search" class="btn btn-primary">查詢</button>
    </form>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <?php if (isset($_POST['search']) && $search_result): ?>
        <h4 class="text-center">🔍 查詢結果：</h4>
        <?php if (mysqli_num_rows($search_result) > 0): ?>
            <table class="table table-bordered table-hover text-center align-middle mt-3">
                <thead class="table-success">
                    <tr>
                        <th>交易編號</th>
                        <th>水果編號</th>
                        <th>水果名稱</th>
                        <th>會員身分證字號</th>
                        <th>供應商名稱</th>
                        <th>購買數量</th>
                        <th>出售單價</th>
                        <th>總金額</th>
                        <th>折扣後金額</th>
                        <th>交易日期</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($search_result)): ?>
                        <tr>
                            <td><?php echo $row['交易編號']; ?></td>
                            <td><?php echo $row['水果編號']; ?></td>
                            <td><?php echo $row['水果名稱']; ?></td>
                            <td><?php echo $row['會員身分證字號']; ?></td>
                            <td><?php echo $row['水果供應商名稱']; ?></td>
                            <td><?php echo $row['購買數量']; ?></td>
                            <td><?php echo $row['出售單價']; ?></td>
                            <td><?php echo $row['總金額']; ?></td>
                            <td><?php echo $row['折扣後金額']; ?></td>
                            <td><?php echo $row['交易日期']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center">查無資料</div>
        <?php endif; ?>
    <?php endif; ?>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
