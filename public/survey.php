<?php
declare(strict_types=1);
session_start();
if (($_SESSION['emilia_survey_access'] ?? false) !== true) {
    header('Location: /survey-gate.php', true, 303);
    exit;
}
$questions = require __DIR__ . '/survey-common.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Goddess Survey — La Davina Emilia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body class="survey-page">
    <header class="survey-header"><a class="brand" href="/"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a><span>Private survey</span></header>
    <main class="survey-shell">
      <section class="survey-intro"><p class="eyebrow">A proper introduction</p><h1>Goddess <em>Survey</em></h1><p>Answer honestly. Emilia reads everything, and she remembers everything. If you lie to her, she will know quickly.</p></section>
      <form class="survey-form" action="/survey-submit.php" method="post">
        <?php foreach ($questions as $key => $question): ?>
          <div class="survey-question">
            <label for="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($question, ENT_QUOTES, 'UTF-8') ?></label>
            <textarea id="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" rows="4" maxlength="5000" required></textarea>
          </div>
        <?php endforeach; ?>
        <label class="consent"><input name="adult_consent" type="checkbox" value="yes" required><span>I confirm that I am at least 18 years old and that I am voluntarily sharing these answers with La Davina Emilia.</span></label>
        <button class="button button-primary" type="submit">Send your answers</button>
        <p class="survey-privacy">Your responses are sent as a private CSV attachment to Emilia and are not stored on this website.</p>
      </form>
    </main>
  </body>
</html>
