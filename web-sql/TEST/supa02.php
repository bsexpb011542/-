<?php include_once('header.php'); ?>

<?php
// // 連接到資料庫
// $dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// // 檢查連接是否成功
// if (!$dbConnection) {
//     die("連接失敗: " . mysqli_connect_error());
// }

// 查詢供應商 Email 相同的數量
$sql_same_email = "SELECT Email, COUNT(*) AS email_count FROM 供應商資料表 WHERE 供應商隱藏 = 0 GROUP BY Email HAVING COUNT(*) > 1";
$result_same_email = mysqli_query($dbConnection, $sql_same_email);
$email_rows = mysqli_num_rows($result_same_email);

// 查詢負責人相同的數量
$sql_same_person = "SELECT 負責人姓名, COUNT(*) AS person_count FROM 供應商資料表 WHERE 供應商隱藏 = 0 GROUP BY 負責人姓名 HAVING COUNT(*) > 1";
$result_same_person = mysqli_query($dbConnection, $sql_same_person);
$person_rows = mysqli_num_rows($result_same_person);

// // 關閉資料庫連接
// mysqli_close($dbConnection);
// ?>

<!DOCTYPE html>
<html>
<head>
    <title>供應商查詢</title>
</head>
<body>

<h2>供應商查詢</h2>

<p>有相同 Email 的供應商數量：<?php echo $email_rows; ?> 個</p>
<p>有相同負責人的供應商數量：<?php echo $person_rows; ?> 個</p>

</body>
</html>
<?php include_once('footer.php'); ?>