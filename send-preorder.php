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

$headers   = [];
$headers[] = 'From: FRIDL Website <no-reply@fridl.shop>';
$headers[] = 'Reply-To: ' . clean_header_field($email);
$headers[] = 'Content-Type: text/plain; charset=UTF-8';

$encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
$sent = @mail($to, $encodedSubject, $body, implode("\r\n", $headers));

if ($sent) {
    echo json_encode(['ok' => true]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'mail_failed']);
}
