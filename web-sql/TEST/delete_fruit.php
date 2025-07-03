<?php
// delete_fruit.php

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
$search_term = isset($_POST['search_term']) ? mysqli_real_escape_string($dbConnection, $_POST['search_term']) : '';
$search_option = isset($_POST['search_option']) ? $_POST['search_option'] : '水果編號';
$search_result = null;

if (isset($_POST['search']) && !empty($search_term)) {
    $sql_search = "SELECT * FROM 水果資料表 WHERE $search_option LIKE '%$search_term%' AND 水果隱藏 = 1";
    $search_result = mysqli_query($dbConnection, $sql_search);
}

// 處理刪除水果
if (isset($_POST['delete_fruit']) && isset($_POST['fruit_ids'])) {
    $fruit_ids = implode("','", $_POST['fruit_ids']);
    $sql_delete = "DELETE FROM 水果資料表 WHERE 水果編號 IN ('$fruit_ids')";
    if (mysqli_query($dbConnection, $sql_delete)) {
        $success_message = "所選水果已成功刪除。";
    } else {
        $error_message = "刪除過程中發生錯誤: " . mysqli_error($dbConnection);
    }
}

// 查詢所有已隱藏的水果資料
$sql_all_hidden_fruits = "SELECT * FROM 水果資料表 WHERE 水果隱藏 = 1";
$all_hidden_fruits_result = mysqli_query($dbConnection, $sql_all_hidden_fruits);

// 關閉資料庫連接
mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>刪除水果資料查詢</title>
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
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="#">🗑️ 刪除水果資料</a>
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
        <h1>刪除水果資料</h1>
        <p class="lead">查詢或刪除已隱藏的水果資料。</p>
    </div>
</section>

<!-- 查詢表單 -->
<section class="container my-5">
    <h3 class="text-center mb-4">🔍 查詢已隱藏水果</h3>
    <form method="post" class="d-flex justify-content-center mb-4">
        <select name="search_option" class="form-select w-25 me-2">
            <option value="水果編號" <?php echo $search_option == '水果編號' ? 'selected' : ''; ?>>水果編號</option>
            <option value="水果名稱" <?php echo $search_option == '水果名稱' ? 'selected' : ''; ?>>水果名稱</option>
        </select>
        <input type="text" name="search_term" class="form-control w-50 me-2" placeholder="輸入水果編號或名稱" value="<?php echo htmlspecialchars($search_term); ?>" required>
        <button type="submit" name="search" class="btn btn-primary">查詢</button>
    </form>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success text-center"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <?php if (isset($search_result) && mysqli_num_rows($search_result) > 0): ?>
        <form method="post">
            <h4 class="text-center">🔍 查詢結果：</h4>
            <table class="table table-bordered table-hover text-center align-middle mt-3">
                <thead class="table-danger">
                    <tr>
                        <th>選擇</th>
                        <th>水果編號</th>
                        <th>水果名稱</th>
                        <th>供應商</th>
                        <th>數量</th>
                        <th>單位</th>
                        <th>進貨單價</th>
                        <th>存放位置</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($search_result)): ?>
                        <tr>
                            <td><input type="checkbox" name="fruit_ids[]" value="<?php echo $row['水果編號']; ?>"></td>
                            <td><?php echo $row['水果編號']; ?></td>
                            <td><?php echo $row['水果名稱']; ?></td>
                            <td><?php echo $row['水果供應商名稱']; ?></td>
                            <td><?php echo $row['公司內現有數量']; ?></td>
                            <td><?php echo $row['單位']; ?></td>
                            <td><?php echo $row['進貨單價']; ?></td>
                            <td><?php echo $row['公司內存放位置']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit" name="delete_fruit" class="btn btn-danger mt-3">確認刪除</button>
        </form>
    <?php else: ?>
        <div class="alert alert-warning text-center">查無資料</div>
    <?php endif; ?>
</section>

<?php include_once('footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
