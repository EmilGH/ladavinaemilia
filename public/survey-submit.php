<?php
declare(strict_types=1);
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_SESSION['emilia_survey_access'] ?? false) !== true) {
    http_response_code(403);
    exit('Survey access required.');
}

$questions = require __DIR__ . '/survey-common.php';
if (($_POST['adult_consent'] ?? '') !== 'yes') {
    http_response_code(422);
    exit('Adult confirmation is required.');
}

$answers = [];
foreach ($questions as $key => $question) {
    $answer = trim((string) ($_POST[$key] ?? ''));
    $wordCount = preg_match_all('/\S+/u', $answer);
    if ($answer === '' || $wordCount === false || $wordCount > 2000) {
        http_response_code(422);
        exit('Please answer every question before sending.');
    }
    $answers[$key] = $answer;
}

$csv = fopen('php://temp', 'r+');
if ($csv === false) {
    http_response_code(500);
    exit('Unable to prepare the response.');
}
fputcsv($csv, array_merge(['Submitted at (UTC)'], array_values($questions)));
fputcsv($csv, array_merge([gmdate('c')], array_values($answers)));
rewind($csv);
$csvData = stream_get_contents($csv);
fclose($csv);

$boundary = 'emilia-' . bin2hex(random_bytes(16));
$filename = 'emilia-survey-' . gmdate('Ymd-His') . '.csv';
$message = "--{$boundary}\r\n";
$message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
$message .= "A new private survey response is attached as a CSV.\r\n\r\n";
$message .= "--{$boundary}\r\n";
$message .= "Content-Type: text/csv; name=\"{$filename}\"\r\n";
$message .= "Content-Transfer-Encoding: base64\r\n";
$message .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n\r\n";
$message .= chunk_split(base64_encode((string) $csvData));
$message .= "--{$boundary}--\r\n";

$headers = [
    'MIME-Version: 1.0',
    "Content-Type: multipart/mixed; boundary=\"{$boundary}\"",
    'From: La Davina Emilia <hi@ladavinaemilia.com>',
];
$sent = mail('emmy@ladavinaemilia.com', 'New Goddess Survey response', $message, implode("\r\n", $headers));
if (!$sent) {
    http_response_code(500);
    exit('Your response could not be delivered. Please try again later.');
}

unset($_SESSION['emilia_survey_access']);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Received — La Davina Emilia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet"><link rel="stylesheet" href="styles.css">
  </head>
  <body class="gate-page"><main class="gate-shell"><a class="brand" href="/"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a><section class="gate-card"><span class="gate-moon" aria-hidden="true">☾</span><p class="eyebrow">Received</p><h1>Emilia will read <em>everything.</em></h1><p>Your answers have been delivered. If you gave her a reason to remember you, she will.</p><a class="button button-primary" href="/">Return to her world</a></section></main></body>
</html>
