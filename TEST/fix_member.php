<?php include_once('header.php'); ?>

<?php
// // 連接到資料庫
// $dbConnection = mysqli_connect("localhost", "root", "", "fruit_company");

// // 檢查連接是否成功
// if (!$dbConnection) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// 修改會員資料
if (isset($_POST['update_member'])) {
    $member_id = strtoupper($_POST['member_id']); // 轉換為大寫

    // 檢查輸入的會員身分證字號格式
    if (preg_match('/^[A-Z]\d{9}$/', $member_id)) {
        // 檢查會員是否存在
        $check_query = "SELECT * FROM 會員資料表 WHERE 會員身分證字號 = '$member_id'";
        $check_result = mysqli_query($dbConnection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // 取得會員資料
            $member_data = mysqli_fetch_assoc($check_result);

            // 顯示修改表單
            echo "<h2>修改會員資料</h2>";
            echo "<form action='' method='post'>
                    <label for='member_id'>會員身分證字號：</label>
                    <input type='text' name='member_id' value='$member_data[會員身分證字號]' pattern='^[A-Z]\d{9}$' title='請輸入正確格式，例如：A123456789' required>

                    <label for='password'>密碼：</label>
                    <input type='password' name='password' value='$member_data[密碼]' required>

                    <label for='member_name'>會員姓名：</label>
                    <input type='text' name='member_name' value='$member_data[會員姓名]' required>

                    <label for='phone'>電話：</label>
                    <input type='text' name='phone' value='$member_data[電話]' required>

                    <label for='mobile'>手機號碼：</label>
                    <input type='text' name='mobile' value='$member_data[手機號碼]' required>

                    <label for='email'>Email：</label>
                    <input type='email' name='email' value='$member_data[Email]' required>

                    <label for='line_status'>是否加入東海水果公司之Line：</label>
                    <select name='line_status' required>
                        <option value='是' " . ($member_data['是否加入東海水果公司之Line'] == '是' ? 'selected' : '') . ">是</option>
                        <option value='不是' " . ($member_data['是否加入東海水果公司之Line'] == '不是' ? 'selected' : '') . ">不是</option>
                    </select>

                    <label for='address'>住址：</label>
                    <input type='text' name='address' value='$member_data[住址]' required>

                    <label for='age'>年齡：</label>
                    <input type='number' name='age' value='$member_data[年齡]' required>

                    <label for='photo'>照片：</label>
                    <input type='file' name='photo'>

                    <label for='discount'>會員折扣：</label>
                    <input type='text' name='discount' value='$member_data[會員折扣]' pattern='^\d+(\.\d{1,2})?$' title='請輸入數字，最多兩位小數' required>

                    <input type='submit' name='submit_update' value='確認修改'>
                </form>";
        } else {
            echo "會員身分證字號不存在";
        }
    } else {
        echo "會員身分證字號格式錯誤，請輸入正確格式，例如：A123456789";
    }
}

// 提交修改後的資料
if (isset($_POST['submit_update'])) {
    // 取得輸入的資料
    $member_id = strtoupper($_POST['member_id']);
    $password = $_POST['password'];
    $member_name = $_POST['member_name'];
    $phone = $_POST['phone'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $line_status = $_POST['line_status'];
    $address = $_POST['address'];
    $age = $_POST['age'];
    $discount = $_POST['discount'];

    // 更新資料
    $update_query = "UPDATE 會員資料表 
                    SET 密碼 = '$password', 會員姓名 = '$member_name', 電話 = '$phone', 手機號碼 = '$mobile',
                        Email = '$email', 是否加入東海水果公司之Line = '$line_status', 住址 = '$address',
                        年齡 = $age, 會員折扣 = $discount
                    WHERE 會員身分證字號 = '$member_id'";

    if (mysqli_query($dbConnection, $update_query)) {
        echo "會員資料更新成功";
    } else {
        echo "會員資料更新失敗: " . mysqli_error($dbConnection);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Member Data</title>
</head>
<body>

<h2>修改會員資料</h2>

<form action="" method="post">
    <label for="member_id">輸入要修改的會員身分證字號：</label>
    <input type="text" name="member_id" pattern="^[A-Z]\d{9}$" title="請輸入正確格式，例如：A123456789" required>

    <input type="submit" name="update_member" value="查詢會員資料">
</form>

</body>
</html>

<?php include_once('footer.php'); ?>