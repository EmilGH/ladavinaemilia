<?php
/**
 * The old passphrase gate.
 *
 * Kept only as a redirect so every existing /gate.php?collection=…&return=…
 * link across the site keeps working. Access is now decided per person in
 * Travativ rather than by a word shared with everybody.
 */
declare(strict_types=1);
session_start();

require __DIR__ . '/travativ-access.php';

$collection = $_GET['collection'] ?? $_POST['collection'] ?? 'home';
if (!is_string($collection) || !isset(EMILIA_COLLECTIONS[$collection])) {
    $collection = 'home';
}

// Only ever return to a path on this site.
$return = $_GET['return'] ?? $_POST['return'] ?? '/';
if (!is_string($return) || !str_starts_with($return, '/') || str_starts_with($return, '//')) {
    $return = '/';
}

// Not configured yet: say so plainly rather than redirecting somewhere broken.
if (!emilia_access_configured()) {
    http_response_code(503);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!doctype html><meta charset="utf-8">'
       . '<title>Momentarily closed — La Davina Emilia</title>'
       . '<body style="font-family:Georgia,serif;background:#12100f;color:#e8e2da;'
       . 'display:grid;place-items:center;min-height:100vh;margin:0;text-align:center">'
       . '<div><p style="font-size:1.4rem">This is momentarily closed.</p>'
       . '<p style="opacity:.7">Please try again shortly.</p>'
       . '<p><a href="/" style="color:#c9a86a">Return to the entrance</a></p></div>';
    exit;
}

$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
      || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
$absolute = ($https ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'ladavinaemilia.com') . $return;

header('Location: ' . emilia_gate_url($collection, $absolute), true, 302);
exit;
