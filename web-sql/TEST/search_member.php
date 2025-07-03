<?php
// search_member.php

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

// 處理查詢會員資料
$search_term = isset($_POST['search_term']) ? mysqli_real_escape_string($dbConnection, $_POST['search_term']) : '';
$search_result = null;

if (isset($_POST['search_member']) && !empty($search_term)) {
    if (preg_match('/^[A-Z]\d{9}$/', $search_term)) {
        $sql_search = "SELECT * FROM 會員資料表 WHERE 會員身分證字號 = '$search_term'";
    } else {
        $sql_search = "SELECT * FROM 會員資料表 WHERE 會員姓名 LIKE '%$search_term%'";
    }
    $search_result = mysqli_query($dbConnection, $sql_search);
}

// 查詢所有會員資料
$sql_all_members = "SELECT * FROM 會員資料表";
$all_members_result = mysqli_query($dbConnection, $sql_all_members);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員資料查詢</title>
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
        <a class="navbar-brand" href="#">🧑‍🤝‍🧑 會員資料查詢</a>
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
        <h1>會員資料查詢</h1>
        <p class="lead">輸入會員身分證字號或姓名以查詢特定會員資料。</p>
    </div>
</section>

<!-- 查詢表單 -->
<section class="container my-5">
    <h3 class="text-center mb-4">🔍 查詢會員</h3>
    <form method="post" class="d-flex justify-content-center mb-4">
        <input type="text" name="search_term" class="form-control w-50 me-2" placeholder="輸入會員身分證字號或姓名" value="<?php echo htmlspecialchars($search_term); ?>" required>
        <button type="submit" name="search_member" class="btn btn-primary">查詢</button>
    </form>

    <?php if (isset($_POST['search_member']) && $search_result): ?>
        <h4 class="text-center">🔍 查詢結果：</h4>
        <?php if (mysqli_num_rows($search_result) > 0): ?>
            <table class="table table-bordered table-hover text-center align-middle mt-3">
                <thead class="table-success">
                    <tr>
                        <th>身分證字號</th>
                        <th>姓名</th>
                        <th>電話</th>
                        <th>手機號碼</th>
                        <th>Email</th>
                        <th>住址</th>
                        <th>年齡</th>
                        <th>照片</th>
                        <th>會員折扣</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($search_result)): ?>
                        <tr>
                            <td><?php echo $row['會員身分證字號']; ?></td>
                            <td><?php echo $row['會員姓名']; ?></td>
                            <td><?php echo $row['電話']; ?></td>
                            <td><?php echo $row['手機號碼']; ?></td>
                            <td><?php echo $row['Email']; ?></td>
                            <td><?php echo $row['住址']; ?></td>
                            <td><?php echo $row['年齡']; ?></td>
                            <td>
                                <img src='data:image/jpeg;base64,<?php echo base64_encode($row['照片']); ?>' alt='會員照片' style='width:100px;height:100px;'>
                            </td>
                            <td><?php echo $row['會員折扣']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning text-center">查無資料</div>
        <?php endif; ?>
    <?php endif; ?>
</section>

<!-- 所有會員資料 -->
<section class="container my-5">
    <h4 class="text-center">🧑‍🤝‍🧑 所有會員資料：</h4>
    <table class="table table-bordered table-hover text-center align-middle mt-3">
        <thead class="table-success">
            <tr>
                <th>身分證字號</th>
                <th>姓名</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($all_members_result)): ?>
                <tr>
                    <td><?php echo $row['會員身分證字號']; ?></td>
                    <td><?php echo $row['會員姓名']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<!-- 頁腳 -->
<?php include_once('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
