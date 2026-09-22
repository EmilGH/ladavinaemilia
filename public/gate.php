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

$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
      || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
$absolute = ($https ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'ladavinaemilia.com') . $return;

header('Location: ' . emilia_gate_url($collection, $absolute), true, 302);
exit;
