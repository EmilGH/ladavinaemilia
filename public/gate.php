<?php
declare(strict_types=1);
session_start();

$gates = [
    'home' => [
        'label' => 'A private glimpse',
        'session' => 'emilia_home_photo_access',
        'hash' => 'ac6124d2fc2b2dd74fc1dc6452a742c45c4ef192d756d8e1fd0910fab13f2b2d',
    ],
    'devotions' => [
        'label' => 'Devotions received',
        'session' => 'emilia_devotions_photo_access',
        'hash' => 'f2d21c4b513d098db70a3e74f3daaa829691e37df0e9d0b1b7fab71916589f72',
    ],
    'salt-and-sun' => [
        'label' => 'Salt & Sun',
        'session' => 'emilia_salt_and_sun_photo_access',
        'hash' => 'fc5759a29057045921bca29a5dcbe2f51d0cbca7c33fcd631db9e2472684218a',
    ],
    'on-the-move' => [
        'label' => 'On the Move',
        'session' => 'emilia_on_the_move_photo_access',
        'hash' => '38e101647aa95bcabb4b347793956b0ebab0deb80ec383fb55276d2c4d175f86',
    ],
    'after-dark' => [
        'label' => 'After Dark',
        'session' => 'emilia_after_dark_photo_access',
        'hash' => '5b267b2d1a8de08e2474f82828f5fcad155028841cce6a8eaef430b9f20e1f17',
    ],
];

$collection = $_POST['collection'] ?? $_GET['collection'] ?? 'home';
if (!is_string($collection) || !isset($gates[$collection])) {
    $collection = 'home';
}
$gate = $gates[$collection];

$return = $_POST['return'] ?? $_GET['return'] ?? '/';
if (!is_string($return) || !str_starts_with($return, '/') || str_starts_with($return, '//')) {
    $return = '/';
}

$error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedHash = hash('sha256', (string) ($_POST['password'] ?? ''));
    if (hash_equals($gate['hash'], $submittedHash)) {
        session_regenerate_id(true);
        $_SESSION[$gate['session']] = true;
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
    <title><?= htmlspecialchars($gate['label'], ENT_QUOTES, 'UTF-8') ?> — La Davina Emilia</title>
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
        <p class="eyebrow"><?= htmlspecialchars($gate['label'], ENT_QUOTES, 'UTF-8') ?></p>
        <h1>Some things are worth <em>earning.</em></h1>
        <p>Emilia keeps her personal moments for those she chooses to let closer. Enter the word she gave you, and this collection will open.</p>
        <?php if ($error): ?><p class="gate-error">That is not the word Emilia gave you. Try again.</p><?php endif; ?>
        <form method="post">
          <label for="password">Emilia’s word</label>
          <input id="password" name="password" type="password" autocomplete="current-password" required autofocus>
          <input name="collection" type="hidden" value="<?= htmlspecialchars($collection, ENT_QUOTES, 'UTF-8') ?>">
          <input name="return" type="hidden" value="<?= htmlspecialchars($return, ENT_QUOTES, 'UTF-8') ?>">
          <button class="button button-primary" type="submit">Open the collection</button>
        </form>
      </section>
      <p class="gate-note">Respect the invitation.</p>
    </main>
  </body>
</html>
