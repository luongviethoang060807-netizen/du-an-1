<?php

use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;

/** Tạo PHPMailer đã cấu hình SMTP dùng chung cho các email xác thực. */
function create_configured_mailer(string $recipientEmail): PHPMailer
{
    if (MAIL_HOST === '' || MAIL_USERNAME === '' || MAIL_PASSWORD === '') {
        throw new RuntimeException('SMTP configuration is incomplete.');
    }

    $mailer = new PHPMailer(true);

    try {
        $mailer->isSMTP();
        $mailer->Host = MAIL_HOST;
        $mailer->SMTPAuth = true;
        $mailer->Username = MAIL_USERNAME;
        $mailer->Password = MAIL_PASSWORD;
        $mailer->Port = MAIL_PORT;
        $mailer->CharSet = 'UTF-8';

        if (MAIL_ENCRYPTION === 'ssl') {
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } elseif (MAIL_ENCRYPTION === 'tls') {
            $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } elseif (MAIL_ENCRYPTION !== '') {
            throw new RuntimeException('Unsupported SMTP encryption setting.');
        }

        $fromAddress = MAIL_FROM_ADDRESS !== '' ? MAIL_FROM_ADDRESS : MAIL_USERNAME;
        $mailer->setFrom($fromAddress, MAIL_FROM_NAME);
        $mailer->addAddress($recipientEmail);
        return $mailer;
    } catch (PHPMailerException $exception) {
        throw new RuntimeException('Unable to configure SMTP mailer.', 0, $exception);
    }
}

/** Gửi link xác minh đăng ký; token thô chỉ được đưa vào email. */
function send_verification_email(string $recipientEmail, string $verificationToken): void
{
    try {
        $mailer = create_configured_mailer($recipientEmail);
        $mailer->isHTML(true);
        $mailer->Subject = 'Thông báo từ Anh Long';

        $verificationUrl = BASE_URL . '?action=api-verify-email&token=' . rawurlencode($verificationToken);
        $safeUrl = htmlspecialchars($verificationUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $expiryMinutes = (int) ceil(EMAIL_VERIFICATION_TTL / 60);
        $mailer->Body = '
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#070b12" style="background-color:#070b12; padding:32px 12px; font-family:Arial,Helvetica,sans-serif;">
                <tr>
                    <td align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:560px; border:1px solid #17414b; background-color:#0d141d;">
                            <tr>
                                <td style="padding:18px 26px; border-bottom:1px solid #17414b; color:#35f2e3; font-family:Courier New,monospace; font-size:12px; letter-spacing:2px;">
                                    NIGHT SIGNAL <span style="color:#ff477e;">//</span> ACCOUNT NOTICE
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:32px 26px; color:#e7f2f4;">
                                    <p style="margin:0 0 12px; color:#ff477e; font-family:Courier New,monospace; font-size:12px;">TRANSMISSION RECEIVED</p>
                                    <h1 style="margin:0 0 18px; color:#35f2e3; font-size:25px; line-height:1.3;">Anh Long nhắc nhở các em:</h1>
                                    <p style="margin:0 0 24px; color:#c2d0d5; font-size:15px; line-height:1.7;">Hãy xác minh email để hoàn tất đăng ký tài khoản.</p>
                                    <p style="margin:0 0 24px;">
                                        <a href="' . $safeUrl . '" style="display:inline-block; padding:13px 20px; border:1px solid #35f2e3; background-color:#10272d; color:#35f2e3; font-family:Courier New,monospace; font-size:13px; font-weight:bold; letter-spacing:1px; text-decoration:none;">XÁC MINH EMAIL</a>
                                    </p>
                                    <p style="margin:0 0 16px; color:#84949d; font-size:12px; line-height:1.6;">Liên kết có hiệu lực trong ' . $expiryMinutes . ' phút.</p>
                                    <p style="margin:0; color:#84949d; font-size:12px; line-height:1.6;">Nếu bạn không đăng ký tài khoản này, hãy bỏ qua email.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 26px; border-top:1px solid #17414b; color:#71838c; font-family:Courier New,monospace; font-size:11px;">END OF MESSAGE <span style="color:#ff477e;">[OK]</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>';
        $mailer->AltBody = "Anh Long nhắc nhở các em:\n\nHãy xác minh email để hoàn tất đăng ký tài khoản:\n{$verificationUrl}\n\nNếu bạn không đăng ký tài khoản này, hãy bỏ qua email.";
        $mailer->send();
    } catch (PHPMailerException $exception) {
        throw new RuntimeException('Unable to send verification email.', 0, $exception);
    }
}

/** Gửi link đặt lại mật khẩu; token chỉ được lưu dạng hash và hết hạn theo cấu hình. */
function send_password_reset_email(string $recipientEmail, string $resetToken): void
{
    try {
        $mailer = create_configured_mailer($recipientEmail);
        $mailer->isHTML(true);
        $mailer->Subject = 'Yêu cầu đặt lại mật khẩu';

        $resetUrl = BASE_URL . '?action=reset-password-bridge&token=' . rawurlencode($resetToken);
        $safeUrl = htmlspecialchars($resetUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $expiryMinutes = (int) ceil(PASSWORD_RESET_TTL / 60);
        $mailer->Body = '
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#070b12" style="background-color:#070b12; padding:32px 12px; font-family:Arial,Helvetica,sans-serif;">
                <tr>
                    <td align="center">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:560px; border:1px solid #17414b; background-color:#0d141d;">
                            <tr><td style="padding:18px 26px; border-bottom:1px solid #17414b; color:#35f2e3; font-family:Courier New,monospace; font-size:12px;">NIGHT SIGNAL // PASSWORD RECOVERY</td></tr>
                            <tr>
                                <td style="padding:32px 26px; color:#e7f2f4;">
                                    <p style="margin:0 0 12px; color:#ff477e; font-family:Courier New,monospace; font-size:12px;">ACCOUNT NOTICE</p>
                                    <h1 style="margin:0 0 18px; color:#35f2e3; font-size:25px; line-height:1.3;">Anh Long nhắc nhở các em:</h1>
                                    <p style="margin:0 0 24px; color:#c2d0d5; font-size:15px; line-height:1.7;">Có yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Liên kết có hiệu lực trong ' . $expiryMinutes . ' phút.</p>
                                    <p style="margin:0 0 24px;"><a href="' . $safeUrl . '" style="display:inline-block; padding:13px 20px; border:1px solid #35f2e3; background-color:#10272d; color:#35f2e3; font-family:Courier New,monospace; font-size:13px; font-weight:bold; text-decoration:none;">ĐẶT LẠI MẬT KHẨU</a></p>
                                    <p style="margin:0; color:#84949d; font-size:12px; line-height:1.6;">Nếu bạn không yêu cầu thay đổi mật khẩu, hãy bỏ qua email này.</p>
                                </td>
                            </tr>
                            <tr><td style="padding:14px 26px; border-top:1px solid #17414b; color:#71838c; font-family:Courier New,monospace; font-size:11px;">END OF MESSAGE [OK]</td></tr>
                        </table>
                    </td>
                </tr>
            </table>';
        $mailer->AltBody = "Anh Long nhắc nhở các em:\n\nCó yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Mở liên kết trong {$expiryMinutes} phút:\n{$resetUrl}\n\nNếu bạn không yêu cầu thay đổi mật khẩu, hãy bỏ qua email này.";
        $mailer->send();
    } catch (PHPMailerException $exception) {
        throw new RuntimeException('Unable to send password reset email.', 0, $exception);
    }
}