<?php
header('Content-Type: application/json; charset=utf-8');

function clean_header_field($value) {
    return trim(str_replace(["\r", "\n"], '', (string) $value));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$name       = clean_header_field($_POST['name'] ?? '');
$email      = clean_header_field($_POST['email'] ?? '');
$firma      = clean_header_field($_POST['firma'] ?? '');
$telefon    = clean_header_field($_POST['telefon'] ?? '');
$menge      = clean_header_field($_POST['menge'] ?? '');
$typ        = clean_header_field($_POST['typ'] ?? '');
$nachricht  = trim((string) ($_POST['nachricht'] ?? ''));
$newsletter = !empty($_POST['newsletter']) ? 'Ja' : 'Nein';

if ($name === '' || $menge === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'invalid_input']);
    exit;
}

$configFile = __DIR__ . '/mail-config.php';
if (!is_file($configFile)) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'config_missing']);
    exit;
}
$config = require $configFile;

$to      = 'service@fridl.shop';
$subject = 'Neue Vorbestellung: ' . $name;

$body  = "Neue Vorbestellung über fridl.shop\n\n";
$body .= "Name: $name\n";
$body .= "E-Mail: $email\n";
$body .= "Firma: " . ($firma !== '' ? $firma : '-') . "\n";
$body .= "Telefon: " . ($telefon !== '' ? $telefon : '-') . "\n";
$body .= "Menge: $menge Dose(n)\n";
$body .= "Kundentyp: " . ($typ !== '' ? $typ : '-') . "\n";
$body .= "Newsletter gewünscht: $newsletter\n";
$body .= "Nachricht:\n" . ($nachricht !== '' ? $nachricht : '-') . "\n";

/**
 * Minimaler SMTP-Client (kein PHPMailer/Composer verfuegbar).
 * Sendet authentifiziert ueber das echte service@fridl.shop-Postfach,
 * damit SPF/DKIM/Reputation stimmen (Fix fuer Microsoft-365-Blockade).
 */
function smtp_send(array $config, string $to, string $subject, string $body, string $replyTo) {
    $errno = 0;
    $errstr = '';
    $socket = @stream_socket_client(
        'ssl://' . $config['smtp_host'] . ':' . $config['smtp_port'],
        $errno,
        $errstr,
        10
    );
    if (!$socket) {
        return false;
    }
    stream_set_timeout($socket, 10);

    $readResponse = function () use ($socket) {
        $data = '';
        while (($line = fgets($socket, 515)) !== false) {
            $data .= $line;
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }
        return $data;
    };
    $sendCommand = function (string $cmd) use ($socket, $readResponse) {
        fwrite($socket, $cmd . "\r\n");
        return $readResponse();
    };

    $readResponse(); // Server-Greeting
    $sendCommand('EHLO fridl.shop');
    $sendCommand('AUTH LOGIN');
    $sendCommand(base64_encode($config['smtp_user']));
    $authResp = $sendCommand(base64_encode($config['smtp_pass']));
    if (strpos($authResp, '235') !== 0) {
        fclose($socket);
        return false;
    }

    $sendCommand('MAIL FROM:<' . $config['smtp_user'] . '>');
    $sendCommand('RCPT TO:<' . $to . '>');
    $sendCommand('DATA');

    $headers  = 'From: FRIDL Website <' . $config['smtp_user'] . ">\r\n";
    $headers .= 'To: <' . $to . ">\r\n";
    $headers .= 'Reply-To: <' . $replyTo . ">\r\n";
    $headers .= 'Subject: =?UTF-8?B?' . base64_encode($subject) . "?=\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "\r\n";

    // Byte-Stuffing: Zeilen, die mit '.' beginnen, verdoppeln (SMTP DATA-Ende-Erkennung)
    $stuffedBody = preg_replace('/^\./m', '..', $body);

    $finalResp = $sendCommand($headers . $stuffedBody . "\r\n.");
    $sendCommand('QUIT');
    fclose($socket);

    return strpos($finalResp, '250') === 0;
}

$sent = smtp_send($config, $to, $subject, $body, $email);

if ($sent) {
    echo json_encode(['ok' => true]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'mail_failed']);
}
