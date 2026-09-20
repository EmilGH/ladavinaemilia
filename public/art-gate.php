<?php
declare(strict_types=1);
session_start();
$error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedHash = hash('sha256', (string) ($_POST['password'] ?? ''));
    $expectedHash = '754139a5761b6145b3dd8f2ed4b4e45ee3f97058f5facdb97dfaec2a865420cf';
    if (hash_equals($expectedHash, $submittedHash)) {
        session_regenerate_id(true);
        $_SESSION['emilia_art_access'] = true;
        header('Location: /art.php', true, 303);
        exit;
    }
    $error = true;
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>The Art of Being Unforgettable — Private Access</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet"><link rel="stylesheet" href="styles.css"></head>
<body class="gate-page"><main class="gate-shell"><a class="brand" href="/"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a><section class="gate-card"><span class="gate-moon" aria-hidden="true">☾</span><p class="eyebrow">The Art of Being Unforgettable</p><h1>Some lessons are only for those who are <em>ready to listen.</em></h1><p>Enter the word Emilia gave you to read her private collection.</p><?php if ($error): ?><p class="gate-error">That is not the word Emilia gave you. Try again.</p><?php endif; ?><form method="post"><label for="password">Emilia’s word</label><input id="password" name="password" type="password" autocomplete="current-password" required autofocus><button class="button button-primary" type="submit">Enter the collection</button></form></section><p class="gate-note">Read slowly. Remember everything.</p></main></body></html>
