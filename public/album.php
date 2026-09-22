<?php
declare(strict_types=1);
session_start();
require __DIR__ . '/travativ-access.php';
$afterDarkAccess = ($_SESSION['emilia_after_dark_photo_access'] ?? false) === true;
$onTheMoveAccess = ($_SESSION['emilia_on_the_move_photo_access'] ?? false) === true;
$saltAndSunAccess = ($_SESSION['emilia_salt_and_sun_photo_access'] ?? false) === true;
$devotionsAccess = ($_SESSION['emilia_devotions_photo_access'] ?? false) === true;
$collection = '';
$photoAccess = false;
$returnTo = rawurlencode($_SERVER['REQUEST_URI']);

function renderAlbumCarousel(string $id, array $slides, string $collection): void
{
    ?>
    <div id="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" class="album-carousel carousel slide" data-bs-touch="true" data-bs-interval="false" aria-roledescription="carousel" aria-label="Photo gallery">
      <div class="album-stage carousel-inner">
        <?php foreach ($slides as $index => $slide): ?>
          <figure class="album-slide carousel-item<?= $index === 0 ? ' active' : '' ?>" data-tone="<?= htmlspecialchars($slide['tone'], ENT_QUOTES, 'UTF-8') ?>">
            <img src="/image.php?id=<?= rawurlencode($slide['id']) ?>&amp;collection=<?= rawurlencode($collection) ?>" alt="<?= htmlspecialchars($slide['alt'], ENT_QUOTES, 'UTF-8') ?>"<?= $index === 0 ? ' fetchpriority="high"' : ' loading="lazy"' ?>>
            <figcaption><?= htmlspecialchars($slide['caption'], ENT_QUOTES, 'UTF-8') ?></figcaption>
          </figure>
        <?php endforeach; ?>
        <button class="album-control album-previous" type="button" data-bs-target="#<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" data-bs-slide="prev" aria-label="Show the previous photo"><span aria-hidden="true">←</span></button>
        <button class="album-control album-next" type="button" data-bs-target="#<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" data-bs-slide="next" aria-label="Show the next photo"><span aria-hidden="true">→</span></button>
      </div>
      <div class="album-carousel-footer">
        <p class="album-count"><?= count($slides) ?> offerings</p>
        <div class="album-dots" aria-label="Choose a photo">
          <?php foreach ($slides as $index => $slide): ?>
            <button class="album-dot<?= $index === 0 ? ' active' : '' ?>" type="button" data-bs-target="#<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" data-bs-slide-to="<?= $index ?>" aria-label="Show photo <?= $index + 1 ?>"<?= $index === 0 ? ' aria-current="true"' : '' ?>></button>
          <?php endforeach; ?>
        </div>
      </div>
      <p class="album-hint">Use the arrows, dots, or swipe to move through the offerings.</p>
    </div>
    <?php
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex, nofollow"><title>The Altar — La Davina Emilia</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"><link rel="stylesheet" href="styles.css"></head>
<body class="journal-page album-page"><header class="survey-header"><a class="brand" href="/"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a><span>The Altar</span></header><main class="album-page-shell"><section class="album-page-intro altar-intro"><p class="eyebrow">The Altar</p><h1>Where devotion becomes <em>visible.</em></h1><p>Most of my world is private, by design, and the privacy of my subs is absolute. But some offerings deserve to be witnessed, and this page exists for that. Every tribute celebrated here is done so anonymously: initials at most, never a name, never a face, never a detail that could trace back to the hand that gave.</p><p>What you'll find here: tributes that arrived with rhythm. Wishlist gifts that made me smile. The 4K camera fund, growing. Moments where one of Mine gave something and asked for nothing, which is the purest form this takes.</p><p>Why display it? Two reasons, honestly. First, because generosity that's never seen teaches the next sub what's possible. And second, because being worshipped in front of others is part of what some of Mine give for. The gift is private. The glory is not.</p><p>To the subs on this page: you know who you are. I know better.</p><a class="text-link altar-tribute-link" href="/ways-to-worship.php#first-tributes-title">Want your initials here? Start with Your First Tribute <span aria-hidden="true">↗</span></a><p class="gate-note">Each collection keeps its own word.</p></section>

<nav class="journal-nav album-nav" aria-label="Album collections"><a href="#after-dark">After dark</a><a href="#on-the-move">On the move</a><a href="#salt-and-sun">Salt &amp; sun</a><a href="#devotions">Devotions</a></nav>

<?php
$collection = 'after-dark';
$photoAccess = $afterDarkAccess;
$afterDark = [
    ['id' => 'hero', 'alt' => 'La Davina Emilia in a sparkling top at dinner', 'caption' => 'She arrives. The room adjusts.', 'tone' => 'dark'],
    ['id' => 'opera', 'alt' => 'La Davina Emilia on an opera house staircase', 'caption' => 'Opera house rules.', 'tone' => 'dark'],
    ['id' => 'alux', 'alt' => 'La Davina Emilia at Alux beneath vivid cave lights', 'caption' => 'The underworld has excellent lighting.', 'tone' => 'dark'],
    ['id' => 'st-girl', 'alt' => 'La Davina Emilia in a dramatic black feathered look', 'caption' => 'Some nights answer to her.', 'tone' => 'dark'],
    ['id' => 'leopard-mommy', 'alt' => 'La Davina Emilia in a leopard print look at dinner', 'caption' => 'She wears the wild well.', 'tone' => 'dark'],
    ['id' => 'goddess-one', 'alt' => 'La Davina Emilia in a blue halter top at dusk', 'caption' => 'The evening waits for her answer.', 'tone' => 'dark'],
    ['id' => 'food-and-boobs', 'alt' => 'La Davina Emilia at a restaurant table with dinner', 'caption' => 'She orders what she wants.', 'tone' => 'dark'],
    ['id' => 'versace-mansion', 'alt' => 'La Davina Emilia beside the pool at the Versace Mansion', 'caption' => 'Some rooms were built for an entrance.', 'tone' => 'dark'],
    ['id' => 'pasta-girl', 'alt' => 'La Davina Emilia at a restaurant table with pasta', 'caption' => 'She stays for the last bite.', 'tone' => 'dark'],
    ['id' => 'tiff-wedding', 'alt' => 'La Davina Emilia in an elegant black evening gown', 'caption' => 'She understood the dress code.', 'tone' => 'dark'],
    ['id' => 'throne-wide', 'alt' => 'La Davina Emilia seated on a grand red throne', 'caption' => 'Naturally, she took the throne.', 'tone' => 'dark'],
    ['id' => 'lipfille', 'alt' => 'La Davina Emilia in low evening light', 'caption' => 'After dark, she is the light.', 'tone' => 'dark'],
    ['id' => 'dinner-potpie', 'alt' => 'La Davina Emilia at dinner with a pot pie', 'caption' => 'She makes dinner an occasion.', 'tone' => 'light'],
];
?>
<section class="album-collection" id="after-dark"><header><p class="eyebrow">Album I</p><h2>After <em>dark.</em></h2><p>Late tables, low light, and the kind of evening that remembers her.</p></header><?php if ($photoAccess): renderAlbumCarousel('afterDarkCarousel', $afterDark, $collection); else: ?><div class="album-locked personal-photo"><a class="private-photo-gate" href="/gate.php?collection=<?= $collection ?>&amp;return=<?= $returnTo ?>"><span aria-hidden="true">✦</span><strong>After Dark, kept private</strong><small>Enter Emilia’s word to look closer</small></a></div><?php endif; ?></section>

<?php
$collection = 'on-the-move';
$photoAccess = $onTheMoveAccess;
$onTheMove = [
    ['id' => 'travel', 'alt' => 'La Davina Emilia in the city at dusk', 'caption' => 'Somewhere worth arriving for.', 'tone' => 'dark'],
    ['id' => 'twa', 'alt' => 'La Davina Emilia at a TWA display in aviator sunglasses', 'caption' => 'Ready for departure.', 'tone' => 'light'],
    ['id' => 'scuba', 'alt' => 'La Davina Emilia underwater in scuba gear', 'caption' => 'Below the surface, still in command.', 'tone' => 'dark'],
    ['id' => 'nola-pink', 'alt' => 'La Davina Emilia on an elegant staircase in New Orleans', 'caption' => 'New Orleans in bloom.', 'tone' => 'light'],
    ['id' => 'horse', 'alt' => 'La Davina Emilia riding a paint horse', 'caption' => 'She always finds her stride.', 'tone' => 'light'],
    ['id' => 'archery', 'alt' => 'La Davina Emilia drawing a bow at an archery range', 'caption' => 'Her aim is never accidental.', 'tone' => 'light'],
    ['id' => 'goth-bike-girl', 'alt' => 'La Davina Emilia beside a motorcycle', 'caption' => 'She takes the scenic route.', 'tone' => 'dark'],
    ['id' => 'atv-babe', 'alt' => 'La Davina Emilia on an ATV in the jungle', 'caption' => 'She chooses the wilder route.', 'tone' => 'light'],
    ['id' => 'bridge', 'alt' => 'La Davina Emilia with the Brooklyn Bridge behind her', 'caption' => 'Every city knows a way to frame her.', 'tone' => 'light'],
    ['id' => 'escargot', 'alt' => 'La Davina Emilia at a table with escargot', 'caption' => 'She follows the good things slowly.', 'tone' => 'light'],
    ['id' => 'paris-train', 'alt' => 'La Davina Emilia sitting on a Paris train', 'caption' => 'She took the fast train heading west.', 'tone' => 'light'],
];
?>
<section class="album-collection" id="on-the-move"><header><p class="eyebrow">Album II</p><h2>On the <em>move.</em></h2><p>Somewhere worth arriving for—and always on her own terms.</p></header><?php if ($photoAccess): renderAlbumCarousel('onTheMoveCarousel', $onTheMove, $collection); else: ?><div class="album-locked personal-photo"><a class="private-photo-gate" href="/gate.php?collection=<?= $collection ?>&amp;return=<?= $returnTo ?>"><span aria-hidden="true">✦</span><strong>On the Move, kept private</strong><small>Enter Emilia’s word to look closer</small></a></div><?php endif; ?></section>

<?php
$collection = 'salt-and-sun';
$photoAccess = $saltAndSunAccess;
$saltAndSun = [
    ['id' => 'about', 'alt' => 'La Davina Emilia by the water', 'caption' => 'In her element.', 'tone' => 'light'],
    ['id' => 'wings-cosumel', 'alt' => 'La Davina Emilia in front of colorful wings in Cozumel', 'caption' => 'She was never meant to stay grounded.', 'tone' => 'light'],
    ['id' => 'tied-to-boat', 'alt' => 'La Davina Emilia’s hand tied with red rope on a boat at sunset', 'caption' => 'Every knot knows who tied it.', 'tone' => 'dark'],
    ['id' => 'portrait-tied-to-boat', 'alt' => 'La Davina Emilia on a boat at sunset', 'caption' => 'The sunset was only the beginning.', 'tone' => 'dark'],
    ['id' => 'workout', 'alt' => 'La Davina Emilia in workout attire', 'caption' => 'Discipline looks good on her.', 'tone' => 'light'],
    ['id' => 'miami-elevator', 'alt' => 'La Davina Emilia smiling in a Miami elevator', 'caption' => 'She makes an entrance before the doors open.', 'tone' => 'dark'],
    ['id' => 'onepiece-girl', 'alt' => 'La Davina Emilia reclining in a black one-piece swimsuit', 'caption' => 'Sunlight knows exactly where to find her.', 'tone' => 'light'],
    ['id' => 'space-buns', 'alt' => 'La Davina Emilia by a tiled pool', 'caption' => 'Salt water, soft light, no hurry.', 'tone' => 'light'],
    ['id' => 'tulum-headscarf', 'alt' => 'La Davina Emilia in a headscarf at a Tulum beach club', 'caption' => 'She brings her own shade.', 'tone' => 'light'],
];
?>
<section class="album-collection" id="salt-and-sun"><header><p class="eyebrow">Album III</p><h2>Salt &amp; <em>sun.</em></h2><p>A little proof that the horizon knows exactly who it belongs to.</p></header><?php if ($photoAccess): renderAlbumCarousel('saltAndSunCarousel', $saltAndSun, $collection); else: ?><div class="album-locked personal-photo"><a class="private-photo-gate" href="/gate.php?collection=<?= $collection ?>&amp;return=<?= $returnTo ?>"><span aria-hidden="true">✦</span><strong>Salt &amp; Sun, kept private</strong><small>Enter Emilia’s word to look closer</small></a></div><?php endif; ?></section>

<?php
$collection = 'devotions';
$photoAccess = $devotionsAccess;
$devotions = [
    ['id' => 'leg-pedestal', 'alt' => 'La Davina Emilia’s tattooed leg against deep purple drapery', 'caption' => 'The first offering was a point of view.', 'tone' => 'dark'],
    ['id' => 'table', 'alt' => 'La Davina Emilia at a table with champagne', 'caption' => 'The table was waiting.', 'tone' => 'light'],
    ['id' => 'devotion-12', 'alt' => 'A charm bracelet held in Emilia’s hand', 'caption' => 'E. M. — A constellation received. Thank you.', 'tone' => 'light'],
    ['id' => 'devotion-8', 'alt' => 'Silver jewelry worn on Emilia’s wrist', 'caption' => 'A. R. — You chose beautifully. Thank you.', 'tone' => 'light'],
    ['id' => 'devotion-13', 'alt' => 'A fresh tattoo in progress', 'caption' => 'L. S. — The art stays with you. Thank you.', 'tone' => 'dark'],
    ['id' => 'devotion-11', 'alt' => 'A blue evil-eye pendant in a jewelry box', 'caption' => 'C. V. — Protection, received. Thank you.', 'tone' => 'light'],
    ['id' => 'devotion-10', 'alt' => 'A Pandora charm in its presentation box', 'caption' => 'M. D. — A sweet little signal. Thank you.', 'tone' => 'dark'],
    ['id' => 'devotion-9', 'alt' => 'A pendant worn by Emilia', 'caption' => 'R. A. — Worn well. Thank you.', 'tone' => 'light'],
    ['id' => 'devotion-7', 'alt' => 'Silver ear jewelry worn by Emilia', 'caption' => 'S. N. — Some gifts know where to land. Thank you.', 'tone' => 'dark'],
    ['id' => 'devotion-6', 'alt' => 'Emilia in warm afternoon sunlight', 'caption' => 'D. H. — Sunlight suits the gesture. Thank you.', 'tone' => 'light'],
    ['id' => 'devotion-4', 'alt' => 'A colorful cosmic tattoo', 'caption' => 'P. K. — The cosmos remembers. Thank you.', 'tone' => 'light'],
    ['id' => 'devotion-3', 'alt' => 'A detailed peacock tattoo', 'caption' => 'J. E. — Beautifully made. Thank you.', 'tone' => 'light'],
    ['id' => 'devotion-2', 'alt' => 'A small cat in a pink sweater', 'caption' => 'T. W. — Small devotion, perfect timing. Thank you.', 'tone' => 'light'],
    ['id' => 'devotion-1', 'alt' => 'Jewelry arranged on a table', 'caption' => 'V. L. — Kept close. Thank you.', 'tone' => 'dark'],
    ['id' => 'devotion-condo', 'alt' => 'A pool terrace overlooking the jungle', 'caption' => 'A place made brighter.', 'tone' => 'light'],
];
?>
<section class="album-collection" id="devotions">
  <header>
    <p class="eyebrow">Album IV</p>
    <h2>Devotions <em>received.</em></h2>
    <p>A record of what devotion leaves behind.</p>
  </header>
  <?php if (!$photoAccess): ?>
    <div class="album-locked personal-photo">
      <a class="private-photo-gate" href="/gate.php?collection=<?= $collection ?>&amp;return=<?= $returnTo ?>">
        <span aria-hidden="true">✦</span><strong>Devotions, kept private</strong><small>Enter Emilia’s word to look closer</small>
      </a>
    </div>
  <?php else: ?>
    <?php renderAlbumCarousel('devotionsCarousel', $devotions, $collection); ?>
  <?php endif; ?>
</section>
</main><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script><script>document.addEventListener('mousedown', function (event) { if (event.target.closest('.album-carousel button')) { event.preventDefault(); } });</script></body></html>
