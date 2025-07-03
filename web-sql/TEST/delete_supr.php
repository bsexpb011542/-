<?php include_once('header.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>刪除供應商</title>
</head>
<body>

<h2>刪除供應商</h2>

<form action="" method="post">
    <label for="supplier_id_to_delete">輸入供應商統一編號：</label>
    <input type="text" name="supplier_id_to_delete" pattern="\d{8}" title="請輸入正確格式，例如：12345678" required>

    <input type="submit" name="delete_supplier" value="刪除供應商">
</form>

</body>
</html>


<?php
// // 連接到資料庫
// $dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// // 檢查連接是否成功
// if (!$dbConnection) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// 刪除供應商
if (isset($_POST['delete_supplier'])) {
    $supplier_id_to_delete = $_POST['supplier_id_to_delete'];

    // 使用正則表達式確認輸入的供應商統一編號格式
    if (preg_match('/^\d{8}$/', $supplier_id_to_delete)) {
        // 檢查輸入的供應商統一編號是否存在
        $check_query = "SELECT * FROM 供應商資料表 WHERE 供應商統一編號 = '$supplier_id_to_delete'";
        $check_result = mysqli_query($dbConnection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // 更新供應商隱藏值為1
            $update_query = "UPDATE 供應商資料表 SET 供應商隱藏 = 1 WHERE 供應商統一編號 = '$supplier_id_to_delete'";
            if (mysqli_query($dbConnection, $update_query)) {
                echo "供應商隱藏值更新成功";
            } else {
                echo "供應商隱藏值更新失敗: " . mysqli_error($dbConnection);
            }
        } else {
            echo "供應商統一編號不存在";
        }
    } else {
        echo "請輸入正確的供應商統一編號格式（八碼數字字串）";
    }
}

// 顯示供應商資料表中「供應商隱藏」值為1的資料
$hidden_suppliers_query = "SELECT * FROM 供應商資料表 WHERE 供應商隱藏 = 1";
$hidden_suppliers_result = mysqli_query($dbConnection, $hidden_suppliers_query);

if (mysqli_num_rows($hidden_suppliers_result) > 0) {
    // 顯示供應商資料
    echo "<h3>已刪除供應商資料表：</h3>";
    echo "<table border='1'>
            <tr>
                <th>供應商統一編號</th>
                <th>水果供應商名稱</th>
                <th>電話</th>
                <th>Email</th>
                <th>住址</th>
                <th>負責人姓名</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($hidden_suppliers_result)) {
        echo "<tr>
                <td>" . $row['供應商統一編號'] . "</td>
                <td>" . $row['水果供應商名稱'] . "</td>
                <td>" . $row['電話'] . "</td>
                <td>" . $row['Email'] . "</td>
                <td>" . $row['住址'] . "</td>
                <td>" . $row['負責人姓名'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "沒有供應商資料";
}
?>






<?php include_once('footer.php'); ?>