<?php include_once('header.php'); ?>

<?php
// // 連接到資料庫
// $dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// // 檢查連接是否成功
// if (!$dbConnection) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// 查詢供應商數量（僅計算供應商隱藏值為 0 的）
$sql_supplier_count = "SELECT COUNT(*) AS supplier_count FROM 供應商資料表 WHERE 供應商隱藏 = 0";
$result_supplier_count = mysqli_query($dbConnection, $sql_supplier_count);
$row_supplier_count = mysqli_fetch_assoc($result_supplier_count);
$supplier_count = $row_supplier_count['supplier_count'];

// // 關閉資料庫連接
// mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>供應商統計資訊</title>
</head>
<body>

<h2>供應商統計資訊</h2>

<p>供應水果給東海水果公司的供應商數量：<?php echo $supplier_count; ?> 家</p>

</body>
</html>
<?php include_once('footer.php'); ?>