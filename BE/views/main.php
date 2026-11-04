<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Home' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= url('/') ?>">CORE_APP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('/') ?>">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= url('?action=products') ?>">Sản phẩm</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <header class="mb-4">
            <a href="<?= url('/') ?>">Trang chủ</a> >> <strong><?= $title ?? '' ?></strong>
            <hr>
        </header>

        <main class="row">
            <?php 
            // Kiểm tra và load view theo chuẩn đường dẫn PATH_VIEW
            if (isset($view) && !empty($view)) {
                $viewPath = PATH_VIEW . $view . '.php';
                if (file_exists($viewPath)) {
                    require_once $viewPath;
                } else {
                    echo '<div class="alert alert-warning">View file không tồn tại: ' . $viewPath . '</div>';
                }
            } else {
                echo '<p>Chào mừng đến với hệ thống.</p>';
            }
            ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>