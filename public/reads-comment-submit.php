<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Please use the reading-room form.');
}
$name = trim((string) ($_POST['name'] ?? ''));
$comment = trim((string) ($_POST['comment'] ?? ''));
if ($name === '' || $comment === '' || strlen($name) > 120 || strlen($comment) > 3000) {
    http_response_code(422);
    exit('Please complete the comment form before sending.');
}

$body = "Pending reading-room comment\n\nName: {$name}\n\nComment:\n{$comment}\n";
$headers = ['MIME-Version: 1.0', 'Content-Type: text/plain; charset=UTF-8', 'From: La Davina Emilia <hi@ladavinaemilia.com>'];
if (!mail('emmy@ladavinaemilia.com', 'Pending reading-room comment', $body, implode("\r\n", $headers))) {
    http_response_code(500);
    exit('Your comment could not be delivered. Please try again later.');
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Pending — La Davina Emilia</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet"><link rel="stylesheet" href="styles.css"></head><body class="gate-page"><main class="gate-shell"><a class="brand" href="/reads.php"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a><section class="gate-card"><span class="gate-moon" aria-hidden="true">☾</span><p class="eyebrow">Your word has arrived</p><h1>pending approval from your <em>Goddess.</em></h1><p>Emilia will read what you sent before deciding whether it belongs in her reading room.</p><a class="button button-primary" href="/reads.php#reads-comment">Return to the reading room</a></section></main></body></html>
