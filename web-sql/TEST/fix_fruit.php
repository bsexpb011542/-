<?php include_once('header.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>刪除水果資料查詢</title>
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

        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h2>刪除水果資料</h2>
<form action="" method="post">
    <label for="fruit_id_to_update">輸入要刪除的水果編號：</label>
    <input type="text" name="fruit_id_to_update" pattern="\d{2}-\d{3}-\d{3}-\d{2}" title="請輸入正確格式，例如：12-345-678-90" required>

    <input type="submit" name="update_hidden" value="刪除水果">
</form>
<?php

// 更新水果隱藏值
if (isset($_POST['update_hidden'])) {
    $fruit_id_to_update = $_POST['fruit_id_to_update'];

    // 檢查輸入的水果編號格式
    if (preg_match('/^\d{2}-\d{3}-\d{3}-\d{2}$/', $fruit_id_to_update)) {
        // 檢查輸入的水果編號是否存在
        $check_query = "SELECT * FROM 水果資料表 WHERE 水果編號 = '$fruit_id_to_update'";
        $check_result = mysqli_query($dbConnection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // 更新水果隱藏值
            $update_query = "UPDATE 水果資料表 SET 水果隱藏 = 1 WHERE 水果編號 = '$fruit_id_to_update'";
            if (mysqli_query($dbConnection, $update_query)) {
                echo "水果隱藏值更新成功";
            } else {
                echo "水果隱藏值更新失敗: " . mysqli_error($dbConnection);
            }
        } else {
            echo "水果編號不存在";
        }
    } else {
        echo "水果編號格式錯誤，請輸入正確格式，例如：12-345-678-90";
    }
}

// 定義要查詢的水果編號或水果名稱（這部分可以從使用者輸入的表單中獲取）
$searchTerm = isset($_GET['search']) ? mysqli_real_escape_string($dbConnection, $_GET['search']) : '';

// 查詢資料庫中的水果資料表，只查詢水果隱藏為0的資料
$sql = "SELECT * FROM 水果資料表 WHERE (水果編號 LIKE '%$searchTerm%' OR 水果名稱 LIKE '%$searchTerm%') AND 水果隱藏 = 1";
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
                <th>水果隱藏</th> <!-- 新增此行，用於顯示水果隱藏狀態 -->
            </tr>";

    // 輸出資料，只顯示水果隱藏為0的資料
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
                <td>" . $row["水果隱藏"] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}


?>







</body>
</html>
<?php include_once('footer.php'); ?>