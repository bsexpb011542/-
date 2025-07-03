<?php include_once('header.php'); ?>



<?php
// // 連接到資料庫
// $dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// // 檢查連接是否成功
// if (!$dbConnection) {
//     die("Connection failed: " . mysqli_connect_error());
// }

$supplier_id = '';
$supplier_data = array();

// 判斷是否有輸入供應商統一編號
if (isset($_POST['supplier_id'])) {
    $supplier_id = $_POST['supplier_id'];

    // 檢查輸入的供應商統一編號格式
    if (preg_match('/^\d{8}$/', $supplier_id)) {
        // 取得該筆資料
        $get_data_query = "SELECT * FROM 供應商資料表 WHERE 供應商統一編號 = '$supplier_id'";
        $result = mysqli_query($dbConnection, $get_data_query);

        if (mysqli_num_rows($result) > 0) {
            // 存取該筆資料
            $supplier_data = mysqli_fetch_assoc($result);
        } else {
            echo "查無此供應商統一編號的資料";
        }
    } else {
        echo "供應商統一編號格式錯誤，請輸入八碼數字字串";
    }
}

// 更新供應商資料
if (isset($_POST['update_supplier'])) {
    $new_supplier_name = $_POST['new_supplier_name'];
    $new_phone = $_POST['new_phone'];
    $new_email = $_POST['new_email'];
    $new_address = $_POST['new_address'];
    $new_responsible_person = $_POST['new_responsible_person'];

    // 檢查輸入的其他欄位資料是否符合規範
    if (
        preg_match('/^\d+$/', $new_phone) &&
        mb_strlen($new_phone, 'utf-8') <= 16 &&
        mb_strlen($new_supplier_name, 'utf-8') <= 12 &&
        filter_var($new_email, FILTER_VALIDATE_EMAIL) &&
        mb_strlen($new_email, 'utf-8') <= 36 &&
        mb_strlen($new_address, 'utf-8') <= 60 &&
        mb_strlen($new_responsible_person, 'utf-8') <= 12
    ) {
        // 更新供應商資料
        $update_query = "UPDATE 供應商資料表 SET
                            水果供應商名稱 = '$new_supplier_name',
                            電話 = '$new_phone',
                            Email = '$new_email',
                            住址 = '$new_address',
                            負責人姓名 = '$new_responsible_person'
                         WHERE 供應商統一編號 = '$supplier_id'";

        if (mysqli_query($dbConnection, $update_query)) {
            echo "供應商資料更新成功";
        } else {
            echo "供應商資料更新失敗: " . mysqli_error($dbConnection);
        }
    } else {
        echo "輸入的資料不符合規範";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>輸入供應商統一編號並更新資料</title>
</head>
<body>

<h2>輸入供應商統一編號並更新資料</h2>

<!-- 輸入供應商統一編號的表單 -->
<form action="" method="post">
    <label for="supplier_id">輸入供應商統一編號：</label>
    <input type="text" name="supplier_id" pattern="\d{8}" title="請輸入八碼數字字串" required>
    <input type="submit" value="取得供應商資料">
</form>

<?php if (!empty($supplier_data)): ?>
    <!-- 顯示供應商資料並提供修改的表單 -->
    <form action="" method="post">
        <input type="hidden" name="supplier_id" value="<?= $supplier_data['供應商統一編號'] ?>">

        <label for="new_supplier_name">新的水果供應商名稱：</label>
        <input type="text" name="new_supplier_name" value="<?= $supplier_data['水果供應商名稱'] ?>" maxlength="12" required>

        <label for="new_phone">新的電話：</label>
        <input type="text" name="new_phone" value="<?= $supplier_data['電話'] ?>" maxlength="16" required>

        <label for="new_email">新的Email：</label>
        <input type="email" name="new_email" value="<?= $supplier_data['Email'] ?>" maxlength="36" required>

        <label for="new_address">新的住址：</label>
        <input type="text" name="new_address" value="<?= $supplier_data['住址'] ?>" maxlength="60" required>

        <label for="new_responsible_person">新的負責人姓名：</label>
        <input type="text" name="new_responsible_person" value="<?= $supplier_data['負責人姓名'] ?>" maxlength="12" required>

        <input type="submit" name="update_supplier" value="更新供應商資料">
    </form>
<?php endif; ?>

</body>
</html>



<?php include_once('footer.php'); ?>