<?php
declare(strict_types=1);
session_start();

$error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedHash = hash('sha256', (string) ($_POST['password'] ?? ''));
    $expectedHash = 'af9ad832f66da2c1668c54273d8eb742642d8621b30bad61ab63e802c4b1cc49';
    if (hash_equals($expectedHash, $submittedHash)) {
        session_regenerate_id(true);
        $_SESSION['emilia_survey_access'] = true;
        header('Location: /survey.php', true, 303);
        exit;
    }
    $error = true;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Private Survey — La Davina Emilia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body class="gate-page">
    <main class="gate-shell">
      <a class="brand" href="/" aria-label="Return to La Davina Emilia"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a>
      <section class="gate-card">
        <span class="gate-moon" aria-hidden="true">☾</span>
        <p class="eyebrow">The private survey</p><h1>Answer her with <em>intention.</em></h1>
        <p>Emilia reads everything. Enter the word she gave you to begin your introduction.</p>
        <?php if ($error): ?><p class="gate-error">That is not the word Emilia gave you. Try again.</p><?php endif; ?>
        <form method="post"><label for="password">Emilia’s word</label><input id="password" name="password" type="password" autocomplete="current-password" required autofocus><button class="button button-primary" type="submit">Begin the survey</button></form>
      </section>
      <p class="gate-note">Honesty is always more interesting.</p>
    </main>
  </body>
</html>
