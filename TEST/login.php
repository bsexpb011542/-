<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            width: 100%;
        }
        .btn-login {
            width: 100%;
            padding: 10px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">🍎 東海水果公司</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">首頁</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">登入</a></li>
                    <li class="nav-item"><a class="nav-link" href="Register.php">註冊</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="login-container">
            <h2>會員登入</h2>
            <form action="login_process.php" method="post">
                <div class="form-group">
                    <label for="user_type">身分：</label>
                    <select name="user_type" id="user_type" class="form-control">
                        <option value="customer">客戶登入</option>
                        <option value="admin">管理登入</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="member_id">會員身分證字號：</label>
                    <input type="text" name="member_id" id="member_id" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">密碼：</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="login" value="登入" class="btn btn-success btn-login">
                </div>
            </form>
        </div>
    </div>

    <?php include_once('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>