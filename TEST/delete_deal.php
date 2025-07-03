<?php include_once('header.php'); ?>

<?php
// // 資料庫連接
// $dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// // 檢查資料庫連接是否成功
// if (!$dbConnection) {
//     die("資料庫連接失敗: " . mysqli_connect_error());
// }

// 刪除水果交易
if (isset($_POST['delete_transaction'])) {
    $transaction_id_to_delete = $_POST['transaction_id_to_delete'];

    // 將水果交易隱藏值設為1
    $sql_update_hidden = "UPDATE 水果交易資料表 SET 水果交易隱藏 = 1 WHERE 交易編號 = $transaction_id_to_delete";

    if (mysqli_query($dbConnection, $sql_update_hidden)) {
        // 顯示刪除成功訊息
        echo "<h3>刪除水果交易成功</h3>";
    } else {
        echo "刪除水果交易失敗: " . mysqli_error($dbConnection);
    }
}

// 顯示所有水果交易隱藏值為1的資料
$sql_show_hidden_transactions = "SELECT * FROM 水果交易資料表 WHERE 水果交易隱藏 = 1";
$result_show_hidden_transactions = mysqli_query($dbConnection, $sql_show_hidden_transactions);

if ($result_show_hidden_transactions && mysqli_num_rows($result_show_hidden_transactions) > 0) {
    echo "<h3>顯示已刪除資料：</h3>";
    echo "<table>
            <tr>
                <th>交易編號</th>
                <th>水果編號</th>
                <th>水果名稱</th>
                <th>出售單價</th>
                <th>購買數量</th>
                <th>總金額</th>
                <th>折扣後金額</th>
                <th>交易日期</th>
                <th>預計交運日期</th>
                <th>實際交運日期</th>
            </tr>";

    while ($row_hidden = mysqli_fetch_assoc($result_show_hidden_transactions)) {
        echo "<tr>
                <td>" . $row_hidden["交易編號"] . "</td>
                <td>" . $row_hidden["水果編號"] . "</td>
                <td>" . $row_hidden["水果名稱"] . "</td>
                <td>" . $row_hidden["出售單價"] . "</td>
                <td>" . $row_hidden["購買數量"] . "</td>
                <td>" . $row_hidden["總金額"] . "</td>
                <td>" . $row_hidden["折扣後金額"] . "</td>
                <td>" . $row_hidden["交易日期"] . "</td>
                <td>" . $row_hidden["預計交運日期"] . "</td>
                <td>" . $row_hidden["實際交運日期"] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>沒有已刪除資料</p>";
}

// // 關閉資料庫連接
// mysqli_close($dbConnection);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>刪除水果交易</title>
</head>
<body>

<h2>刪除水果交易</h2>

<!-- 刪除水果交易表單 -->
<form action="" method="post">
    <label for="transaction_id_to_delete">要刪除的交易編號：</label>
    <input type="number" name="transaction_id_to_delete" required>
    <br>

    <input type="submit" name="delete_transaction" value="刪除交易">
</form>

</body>
</html>


<?php include_once('footer.php'); ?>