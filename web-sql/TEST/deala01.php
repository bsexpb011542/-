<?php
// deala01.php

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
$member_id = isset($_POST['member_id']) ? mysqli_real_escape_string($dbConnection, $_POST['member_id']) : '';
$search_result = null;

if (isset($_POST['search']) && !empty($member_id)) {
    if (preg_match('/^[A-Z]\d{9}$/', $member_id)) {
        $sql = "SELECT 水果供應商名稱, SUM(折扣後金額) AS 總消費金額
                FROM 水果交易資料表
                WHERE 會員身分證字號 = '$member_id'
                GROUP BY 水果供應商名稱";
        $search_result = mysqli_query($dbConnection, $sql);
    } else {
        $error_message = "會員身分證字號格式錯誤，請輸入正確格式 (例如：A123456789)。";
    }
}

// 關閉資料庫連接
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員供應商消費查詢</title>
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
<nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <div class="container">
        <a class="navbar-brand" href="#">💼 會員供應商消費查詢</a>
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
        <h1>會員供應商消費查詢</h1>
        <p class="lead">查詢某位會員在特定供應商的總消費金額。</p>
    </div>
</section>

<!-- 查詢表單 -->
<section class="container my-5">
    <h3 class="text-center mb-4">🔍 查詢會員消費紀錄</h3>
    <form method="post" class="d-flex justify-content-center mb-4">
        <input type="text" name="member_id" class="form-control w-50 me-2" placeholder="輸入會員身分證字號" value="<?php echo htmlspecialchars($member_id); ?>" pattern="[A-Z]\d{9}" title="請輸入正確格式，例如：A123456789" required>
        <button type="submit" name="search" class="btn btn-primary">查詢</button>
    </form>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <?php if (isset($_POST['search']) && $search_result): ?>
        <h4 class="text-center">🔍 查詢結果：</h4>
        <?php if (mysqli_num_rows($search_result) > 0): ?>
            <table class="table table-bordered table-hover text-center align-middle mt-3">
                <thead class="table-info">
                    <tr>
                        <th>水果供應商名稱</th>
                        <th>總消費金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($search_result)): ?>
                        <tr>
                            <td><?php echo $row['水果供應商名稱']; ?></td>
                            <td>$<?php echo number_format($row['總消費金額'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center">查無相關資料，請確認會員身分證字號是否正確。</div>
        <?php endif; ?>
    <?php endif; ?>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
