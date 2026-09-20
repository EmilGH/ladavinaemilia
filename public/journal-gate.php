<?php
declare(strict_types=1);
session_start();
$error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedHash = hash('sha256', (string) ($_POST['password'] ?? ''));
    $expectedHash = '7515b47f6b474e164e458b41607cf9fbbec867c941bed562734f423eca3e604c';
    if (hash_equals($expectedHash, $submittedHash)) {
        session_regenerate_id(true);
        $_SESSION['emilia_journal_access'] = true;
        header('Location: /journal.php', true, 303);
        exit;
    }
    $error = true;
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Emilia’s Journal — Private Access</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet"><link rel="stylesheet" href="styles.css"></head>
<body class="gate-page"><main class="gate-shell"><a class="brand" href="/"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a><section class="gate-card"><span class="gate-moon" aria-hidden="true">☾</span><p class="eyebrow">Emilia’s Journal</p><h1>Some pages are for those who know <em>the word.</em></h1><p>Enter the word Emilia gave you to read her notes from the road.</p><?php if ($error): ?><p class="gate-error">That is not the word Emilia gave you. Try again.</p><?php endif; ?><form method="post"><label for="password">Emilia’s word</label><input id="password" name="password" type="password" autocomplete="current-password" required autofocus><button class="button button-primary" type="submit">Open the journal</button></form></section><p class="gate-note">Read slowly. Remember everything.</p></main></body></html>
