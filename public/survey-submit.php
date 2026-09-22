<?php
declare(strict_types=1);
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_SESSION['emilia_survey_access'] ?? false) !== true) {
    http_response_code(403);
    exit('Survey access required.');
}

$sections = require __DIR__ . '/survey-common.php';
$questions = [];
foreach ($sections as $section) {
    foreach ($section['questions'] as $question) {
        $question['section'] = $section['title'];
        $questions[] = $question;
    }
}

$answers = [];
foreach ($questions as $question) {
    $key = $question['key'];
    $type = $question['type'];
    $required = $question['required'] ?? true;
    $raw = $_POST[$key] ?? null;

    if ($type === 'confirmation') {
        if ($raw !== 'yes') {
            http_response_code(422);
            exit('Adult confirmation is required.');
        }
        $answers[$key] = 'Confirmed: 18+';
        continue;
    }

    if ($type === 'multi') {
        $values = is_array($raw) ? array_values(array_unique(array_filter($raw, 'is_string'))) : [];
        $allowed = $question['options'];
        if (($required && $values === []) || array_diff($values, $allowed) !== []) {
            http_response_code(422);
            exit('Please complete every required question before sending.');
        }
        $answers[$key] = implode(' | ', $values);
        continue;
    }

    if ($type === 'single') {
        $value = is_string($raw) ? trim($raw) : '';
        if (($required && $value === '') || ($value !== '' && !in_array($value, $question['options'], true))) {
            http_response_code(422);
            exit('Please complete every required question before sending.');
        }
        $answers[$key] = $value;
        continue;
    }

    if ($type === 'rank') {
        $ranks = is_array($raw) ? $raw : [];
        $optionCount = count($question['options']);
        if (count($ranks) !== $optionCount) {
            http_response_code(422);
            exit('Please rank every item before sending.');
        }
        $normalized = [];
        foreach ($ranks as $index => $rank) {
            if (!is_numeric($index) || !is_scalar($rank) || !ctype_digit((string) $rank)) {
                http_response_code(422);
                exit('Please rank every item before sending.');
            }
            $index = (int) $index;
            $rank = (int) $rank;
            if (!array_key_exists($index, $question['options']) || $rank < 1 || $rank > $optionCount) {
                http_response_code(422);
                exit('Please rank every item before sending.');
            }
            $normalized[$rank] = $question['options'][$index];
        }
        if (count($normalized) !== $optionCount) {
            http_response_code(422);
            exit('Please use each ranking number once before sending.');
        }
        ksort($normalized);
        $answers[$key] = implode(' | ', array_map(static fn (int $rank, string $option): string => "{$rank}. {$option}", array_keys($normalized), $normalized));
        continue;
    }

    $value = is_scalar($raw) ? trim((string) $raw) : '';
    if ($type === 'number') {
        if (!ctype_digit($value) || (int) $value < 18 || (int) $value > 120) {
            http_response_code(422);
            exit('Please enter a valid age before sending.');
        }
        $answers[$key] = $value;
        continue;
    }
    if ($type === 'money') {
        if (!is_numeric($value) || (float) $value < 0 || (float) $value > 1000000) {
            http_response_code(422);
            exit('Please enter a valid monthly tribute budget before sending.');
        }
        $answers[$key] = '$' . number_format((float) $value, 2, '.', '');
        continue;
    }

    $wordCount = preg_match_all('/\S+/u', $value);
    if (($required && $value === '') || $wordCount === false || $wordCount > 2000 || ($type === 'short' && strlen($value) > 500)) {
        http_response_code(422);
        exit('Please complete every required question before sending.');
    }
    $answers[$key] = $value;
}

$labels = array_map(static fn (array $question): string => $question['section'] . ' — ' . $question['label'], $questions);
$csv = fopen('php://temp', 'r+');
if ($csv === false) {
    http_response_code(500);
    exit('Unable to prepare the response.');
}
fputcsv($csv, array_merge(['Submitted at (UTC)'], $labels));
fputcsv($csv, array_merge([gmdate('c')], array_map(static fn (array $question): string => $answers[$question['key']], $questions)));
rewind($csv);
$csvData = stream_get_contents($csv);
fclose($csv);

$boundary = 'emilia-' . bin2hex(random_bytes(16));
$filename = 'emilia-survey-' . gmdate('Ymd-His') . '.csv';
$message = "--{$boundary}\r\n";
$message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
$message .= "A new private introduction is attached as a CSV.\r\n\r\n";
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
$sent = mail('emmy@ladavinaemilia.com', 'New private introduction', $message, implode("\r\n", $headers));
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
  <body class="gate-page"><main class="gate-shell"><a class="brand" href="/"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a><section class="gate-card"><span class="gate-moon" aria-hidden="true">☾</span><p class="eyebrow">Received</p><h1>Emilia will read <em>everything.</em></h1><p>Your introduction has been delivered. If you gave her a reason to remember you, she will.</p><a class="button button-primary" href="/">Return to her world</a></section></main></body>
</html>
