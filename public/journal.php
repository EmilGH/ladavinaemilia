<?php
declare(strict_types=1);
session_start();
if (($_SESSION['emilia_journal_access'] ?? false) !== true) {
    header('Location: /journal-gate.php', true, 303);
    exit;
}
$entries = require __DIR__ . '/journal-common.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow"><title>Emilia’s Journal — La Davina Emilia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet"><link rel="stylesheet" href="styles.css">
  </head>
  <body class="journal-page">
    <header class="survey-header"><a class="brand" href="/"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a><span>Notes from the road</span></header>
    <main class="journal-shell">
      <section class="journal-intro"><p class="eyebrow">Emilia’s journal</p><h1>Notes from the places that made her <em>stay awhile.</em></h1><p>The most memorable moments, kept in her own words. Read them carefully.</p></section>
      <nav class="journal-nav" aria-label="Journal entries"><?php foreach ($entries as $slug => $entry): ?><a href="#<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($entry['title'], ENT_QUOTES, 'UTF-8') ?></a><?php endforeach; ?></nav>
      <?php foreach ($entries as $slug => $entry): ?>
        <article class="journal-entry" id="<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>">
          <header><p class="eyebrow"><?= htmlspecialchars($entry['eyebrow'], ENT_QUOTES, 'UTF-8') ?> <span aria-hidden="true">✦</span> <?= htmlspecialchars($entry['date'], ENT_QUOTES, 'UTF-8') ?></p><h2><?= htmlspecialchars($entry['title'], ENT_QUOTES, 'UTF-8') ?></h2></header>
          <div class="journal-prose"><?php foreach ($entry['paragraphs'] as $paragraph): ?><p><?= htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8') ?></p><?php endforeach; ?></div>
          <section class="journal-comments" aria-labelledby="comment-<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>"><p class="eyebrow" id="comment-<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>">Leave a word</p><a class="tribute-inline" href="https://youpay.me/ladavinaemilia" target="_blank" rel="noreferrer"><span aria-hidden="true">✦</span><span>Before you leave a word, leave a little tribute for Emilia.</span><span aria-hidden="true">↗</span></a><form action="/comment-submit.php" method="post"><input name="entry" type="hidden" value="<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>"><label for="name-<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>">What should Emilia call you?</label><input id="name-<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>" name="name" type="text" maxlength="120" required><label for="comment-<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>-body">Your comment</label><textarea id="comment-<?= htmlspecialchars($slug, ENT_QUOTES, 'UTF-8') ?>-body" name="comment" rows="5" maxlength="3000" required></textarea><button class="button button-primary" type="submit">Send your comment</button></form><p class="comment-note">Comments are reviewed by your Goddess before they appear here.</p></section>
        </article>
      <?php endforeach; ?>
    </main>
  </body>
</html>
