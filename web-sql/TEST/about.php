<?php include_once('header.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Fruit Inventory</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Fruit Inventory</h2>





<?php

// 新增資料
if (isset($_POST['add_fruit'])) {
    $fruit_name = $_POST['fruit_name'];
    $supplier_name = $_POST['supplier_name'];

    // 其他欄位按需求添加

    $sql_insert = "INSERT INTO 水果資料表 (水果名稱, 水果供應商名稱) VALUES ('$fruit_name', '$supplier_name')";

    if (mysqli_query($dbConnection, $sql_insert)) {
        echo "新增資料成功";
    } else {
        echo "新增資料失敗: " . mysqli_error($dbConnection);
    }
}

// 定義要查詢的水果編號或水果名稱（這部分可以從使用者輸入的表單中獲取）
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($dbConnection, $_GET['search']) : '';

// 查詢資料庫中的水果資料表
$sql = "SELECT * FROM 水果資料表 WHERE 水果編號 LIKE '%$searchTerm%' OR 水果名稱 LIKE '%$searchTerm%'";
$result = mysqli_query($dbConnection, $sql);

// 檢查查詢結果
if (mysqli_num_rows($result) > 0) {
    // 輸出表格標題
    echo "<table>
            <tr>
                <th>水果編號</th>
                <th>水果名稱</th>
                <th>水果供應商名稱</th>
                <th>公司內現有數量</th>
                <th>單位</th>
                <th>進貨單價</th>
                <th>現有價值小計</th>
                <th>公司內存放位置</th>
                <th>進貨日期</th>
                <th>開始促銷日期</th>
                <th>該丟棄之日期</th>
            </tr>";

    // 輸出資料
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row["水果編號"] . "</td>
                <td>" . $row["水果名稱"] . "</td>
                <td>" . $row["水果供應商名稱"] . "</td>
                <td>" . $row["公司內現有數量"] . "</td>
                <td>" . $row["單位"] . "</td>
                <td>" . $row["進貨單價"] . "</td>
                <td>" . $row["現有價值小計"] . "</td>
                <td>" . $row["公司內存放位置"] . "</td>
                <td>" . $row["進貨日期"] . "</td>
                <td>" . $row["開始促銷日期"] . "</td>
                <td>" . $row["該丟棄之日期"] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

// 關閉資料庫連接
// mysqli_close($dbConnection);
?>

</body>
</html>


<?php include_once('footer.php'); ?>