<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>東海水果公司</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?fruits') no-repeat center center/cover;
            padding: 100px 0;
        }
        .hero-section h1, .hero-section h2 {
            color: black;
        }
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
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
                    <li class="nav-item"><a class="nav-link active" href="#">首頁</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">登入</a></li>
                    <li class="nav-item"><a class="nav-link" href="Register.php">註冊</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h1>歡迎來到東海水果公司</h1>
            <h2>請先登入或註冊</h2>
        </div>
    </section>

    <section class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <p class="lead">立即開始探索我們的新鮮水果訂購服務！</p>
                <div class="d-flex justify-content-around">
                    <a href="login.php" class="btn btn-primary btn-lg">登入</a>
                    <a href="Register.php" class="btn btn-warning btn-lg">註冊</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center">
        <h3>東海水果公司</h3>
        <p>電郵 : abcdefg@example.com &nbsp;&nbsp; 電話：02-8888-8888</p>
        <p>&copy; <?php echo date('Y') ?> 版權所有 不得轉載</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>