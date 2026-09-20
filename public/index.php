<?php
declare(strict_types=1);
session_start();
$photoAccess = ($_SESSION['emilia_photo_access'] ?? false) === true;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="La Davina Emilia — a goddess of beautiful standards, far horizons, and unforgettable attention.">
    <title>La Davina Emilia — Enter Her World</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,500;1,600&family=DM+Sans:opsz,wght@9..40,400;9..40,500&family=Playfair+Display:ital,wght@0,500;0,600;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <a class="skip-link" href="#main">Skip to content</a>
    <header class="site-header">
      <a class="brand" href="#top" aria-label="La Davina Emilia, home"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a>
      <nav aria-label="Primary navigation">
        <a href="#emilia">Emilia</a><a href="/album.php">Adventures</a><a href="/journal-gate.php">Journal</a><a class="nav-contact" href="#contact">Introduce yourself</a>
      </nav>
    </header>
    <main id="main">
      <section class="hero" id="top">
        <div class="celestial" aria-hidden="true"><span class="moon"></span><span class="cloud cloud-one"></span><span class="cloud cloud-two"></span><span class="cloud cloud-three"></span><span class="cloud cloud-four"></span><span class="star star-one">✦</span><span class="star star-two">✧</span><span class="star star-three">✦</span></div>
        <div class="hero-copy">
          <p class="eyebrow"><span aria-hidden="true">✦</span> Enter her orbit</p>
          <h1>The moon does not ask to be noticed. <em>It simply pulls the tide.</em></h1>
          <p class="hero-intro">La Davina Emilia is a goddess of beautiful standards, far horizons, and attention that is always earned.</p>
          <div class="hero-actions"><a class="button button-primary" href="#emilia">Meet Emilia</a><a class="text-link" href="#contact">Are you worthy of her time? <span aria-hidden="true">↗</span></a></div>
        </div>
        <figure class="hero-portrait portrait personal-photo">
          <?php if ($photoAccess): ?>
            <img src="image.php?id=hero" alt="La Davina Emilia in a sparkling top at dinner">
          <?php else: ?>
            <a class="private-photo-gate" href="gate.php?return=<?= rawurlencode($_SERVER['REQUEST_URI']) ?>"><span aria-hidden="true">✦</span><strong>A private glimpse</strong><small>Enter Emilia’s word to look closer</small></a>
          <?php endif; ?>
        </figure>
        <p class="hero-caption">The night grows more interesting when she arrives.</p>
      </section>
      <section class="about section" id="emilia">
        <div class="section-label"><span>01</span> The voice behind the wings</div>
        <div class="about-grid">
          <figure class="about-image personal-photo">
            <?php if ($photoAccess): ?>
              <img src="image.php?id=about" alt="La Davina Emilia by the water">
            <?php else: ?>
              <a class="private-photo-gate" href="gate.php?return=<?= rawurlencode($_SERVER['REQUEST_URI']) ?>"><span aria-hidden="true">✦</span><strong>Portrait in her element</strong><small>Enter Emilia’s word to look closer</small></a>
            <?php endif; ?>
          </figure>
          <div class="about-copy">
            <p class="eyebrow">A goddess of her own design</p><h2>Meet <em>Emilia.</em></h2>
            <p class="lead">“Let me tell you who I am, so you know exactly what you’re walking into.”</p>
            <p>I’m La Davina Emilia. You may call me Emmy when you’ve earned it, and only then. I’m a nice goddess at heart: I love taking care of the people who take care of me. I praise, I spoil, I keep—but my time is precious, my attention is earned, and my affection is a gift.</p>
            <p>Small but mighty, I move through a room like it was waiting for me. I do not ask for respect; I simply have it. My life is a beautiful one to be invited into, and if you’re in it, you’re in it on my schedule, at my pace, by my rules.</p>
            <a class="text-link" href="#survey">Consider the invitation <span aria-hidden="true">↗</span></a>
          </div>
        </div>
      </section>
      <section class="worthiness section" id="survey">
        <div class="worthiness-mark" aria-hidden="true"><span>☾</span><i>✦</i><b>✧</b></div>
        <div class="worthiness-copy"><div class="section-label"><span>02</span> The invitation</div><p class="eyebrow">Before you step closer</p><h2>You believe you are <em>worthy?</em></h2><p class="lead">Emilia’s world is not entered by accident. It begins with a thoughtful introduction and a little proof that you know how to pay attention.</p><p>Complete her brief survey, answer honestly, and show her the person behind the screen. <em>The ones who stand out are never forgotten. They’re the ones I keep. 💋</em></p><a class="button button-primary" href="/survey-gate.php">Complete the survey</a></div>
      </section>
      <section class="quote-band" aria-label="Emilia quote"><span class="spark" aria-hidden="true">☾</span><blockquote>“Curiosity is welcome. Respect is required. The rest is earned.”</blockquote></section>
      <section class="journal section" id="journal">
        <div class="journal-heading"><div class="section-label"><span>03</span> Emilia’s journal</div><h2>Letters from the places where she <em>comes alive.</em></h2><p>Thoughts, adventures, small pleasures, and the stories she decides to share with those paying attention.</p></div>
        <div class="journal-grid">
          <a class="journal-item" href="/journal-gate.php"><span>Now reading</span><strong>Notes from the road</strong><i>Open the journal <span aria-hidden="true">↗</span></i></a>
          <a class="journal-item" href="/art-gate.php"><span>Private collection</span><strong>The art of being unforgettable</strong><i>Read the lessons <span aria-hidden="true">↗</span></i></a>
          <a class="journal-item" href="/reads.php"><span>Emilia’s library</span><strong>The Goddess Reads</strong><i>Browse her shelves <span aria-hidden="true">↗</span></i></a>
        </div>
      </section>
      <section class="album section" id="album">
        <div class="album-heading"><div><div class="section-label"><span>04</span> Her adventures</div><h2>Proof that the world <em>looks better</em> in her company.</h2></div><p>An album in progress: cities, saddle paths, late tables, sunlit escapes, and every place Emilia has made memorable. <a class="text-link" href="/album.php">Open the full gallery <span aria-hidden="true">↗</span></a></p></div>
        <div class="album-grid">
          <figure class="album-photo album-tall personal-photo">
            <?php if ($photoAccess): ?><img src="image.php?id=travel" alt="La Davina Emilia in the city at dusk"><?php else: ?><a class="private-photo-gate" href="gate.php?return=<?= rawurlencode($_SERVER['REQUEST_URI']) ?>"><span aria-hidden="true">✦</span><strong>Travel portrait</strong><small>Enter Emilia’s word to look closer</small></a><?php endif; ?>
            <figcaption>Somewhere worth arriving for.</figcaption>
          </figure>
          <figure class="album-photo personal-photo">
            <?php if ($photoAccess): ?><img src="image.php?id=boat" alt="La Davina Emilia on a boat"><?php else: ?><a class="private-photo-gate" href="gate.php?return=<?= rawurlencode($_SERVER['REQUEST_URI']) ?>"><span aria-hidden="true">✦</span><strong>An adventure begins</strong><small>Enter Emilia’s word to look closer</small></a><?php endif; ?>
            <figcaption>She always knows the way.</figcaption>
          </figure>
          <figure class="album-photo personal-photo">
            <?php if ($photoAccess): ?><img src="image.php?id=table" alt="La Davina Emilia at a table with champagne"><?php else: ?><a class="private-photo-gate" href="gate.php?return=<?= rawurlencode($_SERVER['REQUEST_URI']) ?>"><span aria-hidden="true">✦</span><strong>A beautiful evening</strong><small>Enter Emilia’s word to look closer</small></a><?php endif; ?>
            <figcaption>The table was waiting.</figcaption>
          </figure>
        </div>
      </section>
      <section class="contact" id="contact">
        <div><p class="eyebrow"><span aria-hidden="true">✦</span> A proper introduction</p><h2>Think you can keep <em>up?</em></h2></div>
        <div class="contact-copy"><p>Send Emilia a message. Tell her who you are, what makes you interesting, and why you think you would be very good for her. Be respectful. Be generous. Be honest. And do not be boring.</p><a class="button button-light" href="mailto:hi@ladavinaemilia.com">Send Emilia your introduction</a></div>
      </section>
    </main>
    <footer class="site-footer"><a class="brand" href="#top"><span class="brand-mark" aria-hidden="true">✦</span><span>La Davina Emilia</span></a><p>Be good. Be curious. Be memorable.</p><div class="social-links"><a href="https://youpay.me/ladavinaemilia" target="_blank" rel="noreferrer">YouPay.Me</a><a href="https://throne.com/ladavinaemilia" target="_blank" rel="noreferrer">Throne</a><a href="https://x.com/LaDavinaEmilia" target="_blank" rel="noreferrer">X</a></div><small>© 2026 La Davina Emilia. All rights reserved.</small></footer>
  </body>
</html>
