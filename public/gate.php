<?php
declare(strict_types=1);
session_start();

$return = $_POST['return'] ?? $_GET['return'] ?? '/';
if (!is_string($return) || !str_starts_with($return, '/')) {
    $return = '/';
}

$error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedHash = hash('sha256', (string) ($_POST['password'] ?? ''));
    $expectedHash = 'ac6124d2fc2b2dd74fc1dc6452a742c45c4ef192d756d8e1fd0910fab13f2b2d';
    if (hash_equals($expectedHash, $submittedHash)) {
        session_regenerate_id(true);
        $_SESSION['emilia_photo_access'] = true;
        header('Location: ' . $return, true, 303);
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
    <title>A Private Glimpse — La Davina Emilia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body class="gate-page">
    <main class="gate-shell">
      <a class="brand" href="/" aria-label="Return to La Davina Emilia"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a>
      <section class="gate-card">
        <span class="gate-moon" aria-hidden="true">☾</span>
        <p class="eyebrow">A private glimpse</p>
        <h1>Some things are worth <em>earning.</em></h1>
        <p>Emilia keeps her personal moments for those she chooses to let closer. Enter the word she gave you, and the gallery will open.</p>
        <?php if ($error): ?><p class="gate-error">That is not the word Emilia gave you. Try again.</p><?php endif; ?>
        <form method="post">
          <label for="password">Emilia’s word</label>
          <input id="password" name="password" type="password" autocomplete="current-password" required autofocus>
          <input name="return" type="hidden" value="<?= htmlspecialchars($return, ENT_QUOTES, 'UTF-8') ?>">
          <button class="button button-primary" type="submit">Open the gallery</button>
        </form>
      </section>
      <p class="gate-note">Respect the invitation.</p>
    </main>
  </body>
</html>
