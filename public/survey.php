<?php
declare(strict_types=1);
session_start();
if (($_SESSION['emilia_survey_access'] ?? false) !== true) {
    header('Location: /survey-gate.php', true, 303);
    exit;
}
$sections = require __DIR__ . '/survey-common.php';
$questionNumber = 0;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Private Introduction — La Davina Emilia</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body class="survey-page">
    <header class="survey-header"><a class="brand" href="/"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a><span>Private introduction</span></header>
    <main class="survey-shell">
      <section class="survey-intro"><p class="eyebrow">A proper introduction</p><h1>Tell me who you <em>are.</em></h1><p>Take your time. The details matter, and honesty is always more interesting.</p></section>
      <form class="survey-form" action="/survey-submit.php" method="post">
        <?php foreach ($sections as $sectionIndex => $section): ?>
          <section class="survey-section" aria-labelledby="survey-section-<?= $sectionIndex ?>">
            <header><p class="eyebrow">Part <?= str_pad((string) ($sectionIndex + 1), 2, '0', STR_PAD_LEFT) ?></p><h2 id="survey-section-<?= $sectionIndex ?>"><?= htmlspecialchars($section['title'], ENT_QUOTES, 'UTF-8') ?></h2><p><?= htmlspecialchars($section['intro'], ENT_QUOTES, 'UTF-8') ?></p></header>
            <?php foreach ($section['questions'] as $question): ?>
              <?php $questionNumber++; $key = $question['key']; $required = $question['required'] ?? true; ?>
              <fieldset class="survey-question survey-question-<?= htmlspecialchars($question['type'], ENT_QUOTES, 'UTF-8') ?>">
                <legend><span class="survey-number"><?= $questionNumber ?></span><?= htmlspecialchars($question['label'], ENT_QUOTES, 'UTF-8') ?><?= $required ? ' <span aria-hidden="true">*</span>' : '' ?></legend>
                <?php if (isset($question['hint'])): ?><p class="survey-hint"><?= htmlspecialchars($question['hint'], ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
                <?php if ($question['type'] === 'confirmation'): ?>
                  <label class="choice choice-confirmation"><input name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" type="checkbox" value="yes" required><span>18+ confirmation</span></label>
                <?php elseif ($question['type'] === 'short'): ?>
                  <input id="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" type="text" maxlength="500"<?= $required ? ' required' : '' ?>>
                <?php elseif ($question['type'] === 'number'): ?>
                  <input id="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" type="number" min="18" max="120" step="1" inputmode="numeric"<?= $required ? ' required' : '' ?>>
                <?php elseif ($question['type'] === 'money'): ?>
                  <div class="money-input"><span aria-hidden="true">$</span><input id="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" type="number" min="0" max="1000000" step="0.01" inputmode="decimal"<?= $required ? ' required' : '' ?>></div>
                <?php elseif ($question['type'] === 'long'): ?>
                  <textarea id="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" rows="5" maxlength="20000" data-word-limit="2000"<?= $required ? ' required' : '' ?>></textarea>
                  <p class="survey-limit"><span>0</span> / 2,000 words</p>
                <?php elseif ($question['type'] === 'multi'): ?>
                  <div class="choice-grid">
                    <?php foreach ($question['options'] as $option): ?>
                      <label class="choice"><input name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>[]" type="checkbox" value="<?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?>"><span><?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?></span></label>
                    <?php endforeach; ?>
                  </div>
                <?php elseif ($question['type'] === 'single'): ?>
                  <div class="choice-grid choice-grid-single">
                    <?php foreach ($question['options'] as $option): ?>
                      <label class="choice"><input name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" type="radio" value="<?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?>"<?= $required ? ' required' : '' ?>><span><?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?></span></label>
                    <?php endforeach; ?>
                  </div>
                <?php elseif ($question['type'] === 'rank'): ?>
                  <div class="ranking-list">
                    <?php foreach ($question['options'] as $optionIndex => $option): ?>
                      <label><span><?= htmlspecialchars($option, ENT_QUOTES, 'UTF-8') ?></span><select name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>[<?= $optionIndex ?>]" required><option value="" selected disabled>Rank</option><?php for ($rank = 1; $rank <= count($question['options']); $rank++): ?><option value="<?= $rank ?>"><?= $rank ?></option><?php endfor; ?></select></label>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </fieldset>
            <?php endforeach; ?>
          </section>
        <?php endforeach; ?>
        <div class="survey-submit"><button class="button button-primary" type="submit">Send your introduction</button><p class="survey-privacy">Your answers go only to Emilia in a private email attachment. They are never published or shared.</p></div>
      </form>
    </main>
    <script>
      const countWords = value => (value.trim().match(/\S+/g) || []).length;
      document.querySelectorAll('[data-word-limit]').forEach(field => {
        const limit = Number(field.dataset.wordLimit);
        const counter = field.nextElementSibling.querySelector('span');
        const update = () => {
          const count = countWords(field.value);
          counter.textContent = count.toLocaleString();
          field.closest('.survey-question').classList.toggle('over-limit', count > limit);
        };
        field.addEventListener('input', update);
        update();
      });
      document.querySelector('.survey-form').addEventListener('submit', event => {
        const overLimit = [...document.querySelectorAll('[data-word-limit]')].find(field => countWords(field.value) > Number(field.dataset.wordLimit));
        if (overLimit) {
          event.preventDefault();
          overLimit.focus();
          return;
        }
        let invalid = false;
        document.querySelectorAll('.survey-question-multi').forEach(question => {
          const complete = Boolean(question.querySelector('input:checked'));
          question.classList.toggle('survey-invalid', !complete);
          invalid ||= !complete;
        });
        const ranking = document.querySelector('.ranking-list');
        if (ranking) {
          const ranks = [...ranking.querySelectorAll('select')].map(select => select.value);
          const complete = !ranks.includes('') && new Set(ranks).size === ranks.length;
          ranking.classList.toggle('survey-invalid', !complete);
          invalid ||= !complete;
        }
        if (invalid) event.preventDefault();
      });
    </script>
  </body>
</html>
