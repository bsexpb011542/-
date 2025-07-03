<?php
// 資料庫連接
$dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// 檢查資料庫連接是否成功
if (!$dbConnection) {
    die("資料庫連接失敗: " . mysqli_connect_error());
}

// 確認是否有勾選的交易編號
if (isset($_POST['hidden']) && is_array($_POST['hidden'])) {
    $hiddenTransactions = $_POST['hidden'];

    // 更新水果交易資料表的水果交易隱藏狀態
    foreach ($hiddenTransactions as $transactionId) {
        $sqlUpdate = "UPDATE 水果交易資料表 SET 水果交易隱藏 = 1 WHERE 交易編號 = '$transactionId'";
        mysqli_query($dbConnection, $sqlUpdate);

        // 查找相對應的水果編號
        $sqlSelectFruit = "SELECT 水果編號 FROM 水果交易資料表 WHERE 交易編號 = '$transactionId'";
        $resultFruit = mysqli_query($dbConnection, $sqlSelectFruit);
        $rowFruit = mysqli_fetch_assoc($resultFruit);
        $fruitId = $rowFruit['水果編號'];

        // 查找水果資料表中對應水果編號的公司內現有數量
        $sqlSelectQuantity = "SELECT 公司內現有數量 FROM 水果資料表 WHERE 水果編號 = '$fruitId'";
        $resultQuantity = mysqli_query($dbConnection, $sqlSelectQuantity);
        $rowQuantity = mysqli_fetch_assoc($resultQuantity);
        $currentQuantity = $rowQuantity['公司內現有數量'];

        // 查找水果交易資料表中對應交易編號的購買數量
        $sqlSelectPurchaseQuantity = "SELECT 購買數量 FROM 水果交易資料表 WHERE 交易編號 = '$transactionId'";
        $resultPurchaseQuantity = mysqli_query($dbConnection, $sqlSelectPurchaseQuantity);
        $rowPurchaseQuantity = mysqli_fetch_assoc($resultPurchaseQuantity);
        $purchaseQuantity = $rowPurchaseQuantity['購買數量'];

        // 更新水果資料表的公司內現有數量
        $newQuantity = $currentQuantity + $purchaseQuantity;
        $sqlUpdateQuantity = "UPDATE 水果資料表 SET 公司內現有數量 = '$newQuantity' WHERE 水果編號 = '$fruitId'";
        mysqli_query($dbConnection, $sqlUpdateQuantity);
    }
}

// 關閉資料庫連接
mysqli_close($dbConnection);

// 重新導向回顯示頁面
header("Location: mema04.php");
exit();
?>
