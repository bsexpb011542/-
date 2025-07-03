<?php include_once('header.php'); ?>

<?php

// 查詢資料
if (isset($_POST['search'])) {
    $search_type = $_POST['search_type'];
    $search_term = $_POST['search_term'];

    $select_fields = "交易編號, 水果編號, 水果名稱, 會員身分證字號, 購買數量, 出售單價, 總金額, 折扣後金額, 交易日期, 預計交運日期";

    // 根據不同的查詢類型選擇不同的 SQL 查詢條件
    switch ($search_type) {
        case 'transaction_id':
            $sql_search = "SELECT $select_fields FROM 水果交易資料表 WHERE 交易編號 = '$search_term'";
            break;
        case 'fruit_id':
            $sql_search = "SELECT $select_fields FROM 水果交易資料表 WHERE 水果編號 = '$search_term'";
            break;
        case 'member_id':
            $sql_search = "SELECT $select_fields FROM 水果交易資料表 WHERE 會員身分證字號 = '$search_term'";
            break;
        default:
            $sql_search = "SELECT $select_fields FROM 水果交易資料表";
            break;
    }

    $result_search = mysqli_query($dbConnection, $sql_search);

    if (mysqli_num_rows($result_search) > 0) {
        // 顯示查詢結果
        echo "<h3>查詢結果：</h3>";
        echo "<table border='1'>
                <tr>
                    <th>交易編號</th>
                    <th>水果編號</th>
                    <th>水果名稱</th>
                    <th>會員身分證字號</th>
                    <th>購買數量</th>
                    <th>出售單價</th>
                    <th>總金額</th>
                    <th>折扣後金額</th>
                    <th>交易日期</th>
                    <th>預計交運日期</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result_search)) {
            echo "<tr>
                    <td>" . $row['交易編號'] . "</td>
                    <td>" . $row['水果編號'] . "</td>
                    <td>" . $row['水果名稱'] . "</td>
                    <td>" . $row['會員身分證字號'] . "</td>
                    <td>" . $row['購買數量'] . "</td>
                    <td>" . $row['出售單價'] . "</td>
                    <td>" . $row['總金額'] . "</td>
                    <td>" . $row['折扣後金額'] . "</td>
                    <td>" . $row['交易日期'] . "</td>
                    <td>" . $row['預計交運日期'] . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "查無資料";
    }
}

// 關閉資料庫連接
mysqli_close($dbConnection);

?>

<?php include_once('footer.php'); ?>