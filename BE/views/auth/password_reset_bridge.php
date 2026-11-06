<?php
$continueUrl = isset($continueUrl) && is_string($continueUrl)
    ? $continueUrl
    : FRONTEND_URL . '/forgot-password';
$isValid = isset($isValid) && $isValid === true;
$safeContinueUrl = htmlspecialchars($continueUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$scriptContinueUrl = json_encode(
    $continueUrl,
    JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
);
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="referrer" content="no-referrer">
    <title>Khôi phục mật khẩu</title>
    <style>
        :root {
            color-scheme: dark;
            font-family: "Courier New", monospace;
            background: #070b12;
            color: #e7f2f4;
        }

        * { box-sizing: border-box; }

        body {
            display: grid;
            min-height: 100vh;
            margin: 0;
            padding: 24px;
            place-items: center;
            background: radial-gradient(ellipse at 50% 0, #10272d 0, #070b12 65%);
        }

        main {
            width: min(100%, 440px);
            padding: 28px;
            border: 1px solid #35f2e3;
            box-shadow: 0 0 28px #35f2e322;
        }

        .eyebrow { color: #ff477e; font-size: 12px; letter-spacing: 2px; }
        h1 { margin: 18px 0 10px; color: #35f2e3; font-size: 24px; }
        p { color: #c2d0d5; line-height: 1.6; }

        a {
            display: inline-block;
            margin-top: 12px;
            padding: 12px 16px;
            border: 1px solid #35f2e3;
            color: #35f2e3;
            text-decoration: none;
        }

        a:hover { background: #10272d; }
        .expired h1 { color: #ff477e; }
        .expired a { border-color: #ff477e; color: #ff477e; }
    </style>
</head>
<body>
    <main class="<?= $isValid ? 'verified' : 'expired' ?>">
        <div class="eyebrow">NIGHT SIGNAL // ACCOUNT RECOVERY</div>
        <?php if ($isValid): ?>
            <h1>Liên kết đã xác thực</h1>
            <p>Đang chuyển bạn đến biểu mẫu đặt lại mật khẩu trong 8 giây.</p>
            <p>Nếu không tự chuyển, hãy tiếp tục bằng nút bên dưới.</p>
            <a href="<?= $safeContinueUrl ?>">Tiếp tục đặt lại mật khẩu</a>
        <?php else: ?>
            <h1>Liên kết không còn hợp lệ</h1>
            <p>Liên kết có thể đã hết hạn hoặc đã được sử dụng.</p>
            <a href="<?= $safeContinueUrl ?>">Yêu cầu liên kết mới</a>
        <?php endif; ?>
    </main>

    <?php if ($isValid && $scriptContinueUrl !== false): ?>
        <script>
            window.setTimeout(() => window.location.replace(<?= $scriptContinueUrl ?>), 8000)
        </script>
    <?php endif; ?>
</body>
</html>