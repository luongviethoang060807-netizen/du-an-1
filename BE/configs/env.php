<?php
// tự động xác định base_url dựa vào môi trường thực tế
$_protocol = (!empty($_SERVER['HTTPS'])&& $_SERVER['HTTP'] !== 'off') ? 'https' : 'http';
// xác định giao thức khi kết nối
$_host = $_SERVER['HTTP_HOST'] ?? 'localhost'; 
// xác định host và post dùng để kết nối
$_script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
// xác định trả về /basemvc/index.php
$_base = rtrim(dirname($_script),'/\\').'/';
// xác định trả về mặc định /basemvc
define('BASE_URL',$_protocol.'://'.$_host.$_base);
unset($_protocol,$_host,$_script,$_base);

define('PATH_ROOT', __DIR__.'/../'); // trả về folder gốc
define('PATH_VIEW', PATH_ROOT.'views/'); // trả về folder views
define('PATH_VIEW_MAIN', PATH_ROOT.'views/main.php'); // trả về home của người dùng
define('BASE_ASSETS_UPLOADS', BASE_URL.'assets/uploads'); // hiển thị ảnh
define('PATH_ASSETS_UPLOADS', PATH_ROOT.'assets/uploads'); // đường dẫn vật lý dùng để upload file
define('PATH_MODEL', PATH_ROOT. 'models/'); // trả về models
define('PATH_CONTROLLER', PATH_ROOT. 'controllers/'); // trả về controllers

define('BASE_ASSETS_JS', BASE_URL. 'assets/js/'); // trả về atssets/js
define('PATH_EXTENSION', PATH_ROOT. 'extensions/'); // trả về extensions

// cấu hình
define('DB_HOST', 'localhost');
define('DB_NAME', 'du-an-1');
define('DB_PORT', '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_OPTIONS',[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

// JWT auth config
define('JWT_SECRET', 'du-an-1-demo-secret-key');
define('JWT_TTL', 3600); // 1 giờ
define('EMAIL_VERIFICATION_TTL', 3600); // Link xác minh đăng ký có hiệu lực 1 giờ
define('PASSWORD_RESET_TTL', 3600); // Link đặt lại mật khẩu có hiệu lực 1 giờ
define('FRONTEND_URL', rtrim(getenv('FRONTEND_URL') ?: 'http://localhost:5173', '/'));

// SMTP Gmail configuration
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'xuanlonghh4@gmail.com');
define('MAIL_PASSWORD', 'bhuojuathgpeejnj');
define('MAIL_FROM_ADDRESS', 'xuanlonghh4@gmail.com');
define('MAIL_FROM_NAME', 'Anh Long');
define('MAIL_ENCRYPTION', 'tls');