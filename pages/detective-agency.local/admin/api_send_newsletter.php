<?php
declare(strict_types=1);

session_start();
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../vendor/autoload.php';

// ВАЖНО: поправь путь, если у тебя db.php лежит в /api/db.php
require_once __DIR__ . '/db.php'; // <-- если у тебя db.php именно там
// require_once __DIR__ . '/../db.php';  // <-- или так, если db.php в корне

use PHPMailer\PHPMailer\PHPMailer;

function json_ok(array $data = []): void
{
    echo json_encode(['success' => true] + $data, JSON_UNESCAPED_UNICODE);
    exit;
}
function json_fail(string $message, int $code = 400): void
{
    http_response_code($code);
    echo json_encode(['success' => false, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

// защита: только админ
if (empty($_SESSION['admin_id'])) {
    json_fail('Нет доступа (не админ)', 403);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_fail('Method not allowed', 405);
}

$in = json_decode((string) file_get_contents('php://input'), true);
$text = trim((string) ($in['message'] ?? ''));

if ($text === '') {
    json_fail('Введите текст рассылки');
}

// ===== SMTP Yandex (твои данные) =====
$SMTP_USER = 'gelyak0t@yandex.by';
$SMTP_PASS = 'ljyzpttwxufnrflb';
$FROM_NAME = 'Detective Agency';
// =====================================

try {
    //========================== СОХРАНЕНИЕ В TXT ФАЙЛ ==========================

    $logDir = __DIR__ . '/../logs';

    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }

    $logFile = $logDir . '/mail_log.txt';

    $date = date('Y-m-d H:i:s');

    $logText = "==============================\n";
    $logText .= "Дата рассылки: {$date}\n";
    $logText .= "Текст сообщения:\n{$text}\n";
    $logText .= "==============================\n\n";

    file_put_contents($logFile, $logText, FILE_APPEND);


    // Берём email всех активных клиентов
    $st = $pdo->query("SELECT email FROM `клиент` WHERE `Статус`='active' AND email<>''");
    $emails = $st->fetchAll(PDO::FETCH_COLUMN);

    if (!$emails) {
        json_fail('В базе нет получателей (клиенты с email)');
    }

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    $mail->isSMTP();
    $mail->Host = 'smtp.yandex.ru';
    $mail->SMTPAuth = true;
    $mail->Username = $SMTP_USER;
    $mail->Password = $SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom($SMTP_USER, $FROM_NAME);
    $mail->Subject = 'Сообщение от Detective Agency';
    $mail->isHTML(false);
    $mail->Body = $text;

    $sent = 0;
    $failed = 0;

    foreach ($emails as $to) {
        $to = trim((string) $to);
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $failed++;
            continue;
        }

        $mail->clearAddresses();
        $mail->addAddress($to);

        try {
            $mail->send();
            $sent++;
        } catch (\Throwable $e) {
            $failed++;
        }
    }

    json_ok([
        'sent' => $sent,
        'failed' => $failed,
        'total' => count($emails)
    ]);

} catch (\Throwable $e) {
    json_fail('Ошибка отправки: ' . $e->getMessage(), 500);
}
