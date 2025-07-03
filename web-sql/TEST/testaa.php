<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>水果訂貨網站</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: url('https://source.unsplash.com/1920x1080/?fruits') no-repeat center center/cover;
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }
        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- 頂部導航欄 -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">🍎 水果訂貨平台</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">首頁</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">訂單</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">聯絡我們</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center py-5">
        <div class="container">
            <h1>新鮮水果，快速送達！</h1>
            <p class="lead">我們提供最新鮮的水果，滿足您的每日所需。</p>
            <button class="btn btn-primary btn-lg">立即訂購</button>
        </div>
    </section>

    <!-- 水果訂購表格 -->
    <section class="container my-5">
        <h2 class="text-center mb-4">📋 水果訂購清單</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-success">
                    <tr>
                        <th>圖片</th>
                        <th>水果名稱</th>
                        <th>價格 (每公斤)</th>
                        <th>數量</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="https://source.unsplash.com/50x50/?apple" alt="蘋果"></td>
                        <td>蘋果</td>
                        <td>$100</td>
                        <td><input type="number" class="form-control" value="1" min="1"></td>
                        <td><button class="btn btn-sm btn-primary">加入購物車</button></td>
                    </tr>
                    <tr>
                        <td><img src="https://source.unsplash.com/50x50/?banana" alt="香蕉"></td>
                        <td>香蕉</td>
                        <td>$60</td>
                        <td><input type="number" class="form-control" value="1" min="1"></td>
                        <td><button class="btn btn-sm btn-primary">加入購物車</button></td>
                    </tr>
                    <tr>
                        <td><img src="https://source.unsplash.com/50x50/?grape" alt="葡萄"></td>
                        <td>葡萄</td>
                        <td>$150</td>
                        <td><input type="number" class="form-control" value="1" min="1"></td>
                        <td><button class="btn btn-sm btn-primary">加入購物車</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- 訂單按鈕 -->
    <section class="text-center my-4">
        <button class="btn btn-lg btn-success">提交訂單</button>
    </section>

    <!-- 頁腳 -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 水果訂貨平台. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
