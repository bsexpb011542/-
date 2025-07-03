<?php include_once('header.php'); ?>

<?php
// // 連接到資料庫
// $dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// // 檢查連接是否成功
// if (!$dbConnection) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// 取得要修改的靜止會員資料
if (isset($_POST['edit_member'])) {
    $edit_member_id = strtoupper($_POST['edit_member_id']);

    // 檢查輸入的會員身分證字號格式
    if (preg_match('/^[A-Z]\d{9}$/', $edit_member_id)) {
        // 檢查靜止會員資料表中是否存在該會員
        $check_query = "SELECT * FROM 靜止會員資料表 WHERE 會員身分證字號 = '$edit_member_id'";
        $check_result = mysqli_query($dbConnection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // 取得靜止會員資料
            $select_query = "SELECT * FROM 靜止會員資料表 WHERE 會員身分證字號 = '$edit_member_id'";
            $select_result = mysqli_query($dbConnection, $select_query);

            $edit_member_data = mysqli_fetch_assoc($select_result);
        } else {
            echo "靜止會員身分證字號不存在";
        }
    } else {
        echo "靜止會員身分證字號格式錯誤，請輸入正確格式，例如：A123456789";
    }
}

// 修改靜止會員資料
if (isset($_POST['update_member'])) {
    $edit_member_id = strtoupper($_POST['edit_member_id']);
    $edit_password = $_POST['edit_password'];
    $edit_member_name = $_POST['edit_member_name'];
    $edit_phone = $_POST['edit_phone'];
    $edit_mobile = $_POST['edit_mobile'];
    $edit_email = $_POST['edit_email'];
    $edit_line_status = $_POST['edit_line_status'];
    $edit_address = $_POST['edit_address'];
    $edit_age = $_POST['edit_age'];
    $edit_photo = $_POST['edit_photo'];
    $edit_discount = $_POST['edit_discount'];

    // 檢查輸入的會員身分證字號格式
    if (preg_match('/^[A-Z]\d{9}$/', $edit_member_id)) {
        // 更新靜止會員資料
        $update_query = "UPDATE 靜止會員資料表 
                         SET 密碼 = '$edit_password', 會員姓名 = '$edit_member_name', 電話 = '$edit_phone', 手機號碼 = '$edit_mobile',
                             Email = '$edit_email', 是否加入東海水果公司之Line = '$edit_line_status', 住址 = '$edit_address',
                             年齡 = '$edit_age', 照片 = '$edit_photo', 會員折扣 = '$edit_discount'
                         WHERE 會員身分證字號 = '$edit_member_id'";

        if (mysqli_query($dbConnection, $update_query)) {
            echo "靜止會員資料更新成功";
        } else {
            echo "靜止會員資料更新失敗: " . mysqli_error($dbConnection);
        }
    } else {
        echo "靜止會員身分證字號格式錯誤，請輸入正確格式，例如：A123456789";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Static Member</title>
</head>
<body>

<h2>編輯靜止會員資料</h2>

<form action="" method="post">
    <label for="edit_member_id">輸入要編輯的會員身分證字號：</label>
    <input type="text" name="edit_member_id" pattern="[A-Z]\d{9}" title="請輸入正確格式，例如：A123456789" required>
    <input type="submit" name="edit_member" value="查詢靜止會員資料">
</form>

<?php
if (isset($edit_member_data)) {
    // 顯示編輯表單
    ?>
    <form action="" method="post">
        <input type="hidden" name="edit_member_id" value="<?php echo $edit_member_data['會員身分證字號']; ?>">

        <label for="edit_password">密碼：</label>
        <input type="password" name="edit_password" value="<?php echo $edit_member_data['密碼']; ?>" required>

        <label for="edit_member_name">會員姓名：</label>
        <input type="text" name="edit_member_name" value="<?php echo $edit_member_data['會員姓名']; ?>" required>

        <label for="edit_phone">電話：</label>
        <input type="text" name="edit_phone" value="<?php echo $edit_member_data['電話']; ?>">

        <label for="edit_mobile">手機號碼：</label>
        <input type="text" name="edit_mobile" value="<?php echo $edit_member_data['手機號碼']; ?>">

        <label for="edit_email">Email：</label>
        <input type="email" name="edit_email" value="<?php echo $edit_member_data['Email']; ?>">

        <label for="edit_line_status">是否加入東海水果公司之Line：</label>
        <select name="edit_line_status">
            <option value="是" <?php echo ($edit_member_data['是否加入東海水果公司之Line'] == '是') ? 'selected' : ''; ?>>是</option>
            <option value="不是" <?php echo ($edit_member_data['是否加入東海水果公司之Line'] == '不是') ? 'selected' : ''; ?>>不是</option>
        </select>

        <label for="edit_address">住址：</label>
        <input type="text" name="edit_address" value="<?php echo $edit_member_data['住址']; ?>">

        <label for="edit_age">年齡：</label>
        <input type="number" name="edit_age" value="<?php echo $edit_member_data['年齡']; ?>">

        <label for="edit_photo">照片：</label>
        <input type="text" name="edit_photo" value="<?php echo $edit_member_data['照片']; ?>">

        <label for="edit_discount">會員折扣：</label>
        <input type="text" name="edit_discount" value="<?php echo $edit_member_data['會員折扣']; ?>">

        <input type="submit" name="update_member" value="更新靜止會員資料">
    </form>
    <?php
}
?>

</body>
</html>



<?php include_once('footer.php'); ?>