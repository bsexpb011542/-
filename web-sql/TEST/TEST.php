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

<!-- 新增資料表單 -->
<form action="" method="post">
    <!-- 新增水果編號欄位 -->
    <label for="fruit_id">水果編號：</label>
    <input type="text" name="fruit_id" pattern="\d{2}-\d{3}-\d{3}-\d{2}" title="請輸入正確格式，例如：12-345-678-90" required>

    <label for="fruit_name">水果名稱：</label>
    <input type="text" name="fruit_name" required>

    <label for="supplier_name">供應商名稱：</label>
    <input type="text" name="supplier_name" required>

    <label for="quantity">公司內現有數量：</label>
    <input type="number" name="quantity" required>

    <label for="unit">單位：</label>
    <input type="text" name="unit" required>

    <label for="unit_price">進貨單價：</label>
    <input type="number" name="unit_price" step="0.01" required>

    <label for="storage_location">公司內存放位置：</label>
    <input type="text" name="storage_location" required>

    <label for="purchase_date">進貨日期：</label>
    <input type="date" name="purchase_date" required>

    <label for="promotion_start_date">開始促銷日期：</label>
    <input type="date" name="promotion_start_date" required>

    <label for="expiration_date">該丟棄之日期：</label>
    <input type="date" name="expiration_date" required>

    <input type="submit" name="add_fruit" value="新增資料">
</form>



<?php

// 新增資料
if (isset($_POST['add_fruit'])) {
    $fruit_name = $_POST['fruit_name'];
    $supplier_name = $_POST['supplier_name'];
    $quantity = $_POST['quantity'];
    $unit = $_POST['unit'];
    $unit_price = $_POST['unit_price'];
    $storage_location = $_POST['storage_location'];
    $purchase_date = $_POST['purchase_date'];
    $promotion_start_date = $_POST['promotion_start_date'];
    $expiration_date = $_POST['expiration_date'];
    $fruit_id = $_POST['fruit_id'];

   // 驗證日期的順序
   if (strtotime($expiration_date) >= strtotime($promotion_start_date) && strtotime($promotion_start_date) >= strtotime($purchase_date)) {
    // 驗證水果編號格式
    if (preg_match('/^\d{2}-\d{3}-\d{3}-\d{2}$/', $fruit_id)) {
        // 驗證公司內現有數量為正整數
        if (is_numeric($quantity) && $quantity > 0 && intval($quantity) == $quantity) {
            // 驗證進貨單價為非零正數
            if (is_numeric($unit_price) && $unit_price > 0) {
                // 驗證水果編號是否重複
                $sql_check_duplicate = "SELECT COUNT(*) AS count FROM 水果資料表 WHERE 水果編號 = '$fruit_id'";
                $result_check_duplicate = mysqli_query($dbConnection, $sql_check_duplicate);
                $row_check_duplicate = mysqli_fetch_assoc($result_check_duplicate);

                if ($row_check_duplicate['count'] == 0) {
                    // 計算現有價值小計
                    $subtotal = $quantity * $unit_price;

                    $sql_insert = "INSERT INTO 水果資料表 (水果編號, 水果名稱, 水果供應商名稱, 公司內現有數量, 單位, 進貨單價, 現有價值小計, 公司內存放位置, 進貨日期, 開始促銷日期, 該丟棄之日期)
                                   VALUES ('$fruit_id', '$fruit_name', '$supplier_name', $quantity, '$unit', $unit_price, $subtotal, '$storage_location', '$purchase_date', '$promotion_start_date', '$expiration_date')";

                    if (mysqli_query($dbConnection, $sql_insert)) {
                        echo "新增資料成功";
                    } else {
                        echo "新增資料失敗: " . mysqli_error($dbConnection);
                    }
                } else {
                    echo "水果編號重複，請輸入不同的水果編號";
                }
            } else {
                echo "進貨單價錯誤，請輸入非零正數";
            }
        } else {
            echo "公司內現有數量錯誤，請輸入正整數";
        }
    } else {
        echo "水果編號格式錯誤，請輸入正確格式，例如：12-345-678-90";
    }
} else {
    echo "日期順序錯誤，請確保日期的順序為進貨日期 <= 開始促銷日期 <= 該丟棄之日期";
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