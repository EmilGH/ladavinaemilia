<?php
declare(strict_types=1);
session_start();

$collections = [
    'home' => 'emilia_home_photo_access',
    'devotions' => 'emilia_devotions_photo_access',
    'salt-and-sun' => 'emilia_salt_and_sun_photo_access',
    'on-the-move' => 'emilia_on_the_move_photo_access',
    'after-dark' => 'emilia_after_dark_photo_access',
];

$assets = [
    'hero' => ['file' => 'hero.php', 'collections' => ['after-dark']],
    'about' => ['file' => 'about.php', 'collections' => ['home', 'salt-and-sun']],
    'travel' => ['file' => 'travel.php', 'collections' => ['home', 'on-the-move']],
    'boat' => ['file' => 'boat.php', 'collections' => ['on-the-move']],
    'table' => ['file' => 'table.php', 'collections' => ['devotions']],
    'leg-pedestal' => ['file' => 'assets/leg-pedestal.jpg', 'collections' => ['devotions'], 'prefixed' => false],
    'opera' => ['file' => 'opera.php', 'collections' => ['after-dark']],
    'alux' => ['file' => 'alux.php', 'collections' => ['after-dark']],
    'twa' => ['file' => 'twa.php', 'collections' => ['on-the-move']],
    'scuba' => ['file' => 'scuba.php', 'collections' => ['on-the-move']],
    'nola-pink' => ['file' => 'nola-pink.php', 'collections' => ['on-the-move']],
    'nola-streetlight' => ['file' => 'nola-streetlight.php', 'collections' => ['on-the-move']],
    'horse' => ['file' => 'horse.php', 'collections' => ['on-the-move']],
    'wings-cosumel' => ['file' => 'wings-cosumel.php', 'collections' => ['salt-and-sun']],
    'workout' => ['file' => 'workout.php', 'collections' => ['salt-and-sun']],
    'tied-to-boat' => ['file' => 'tied-to-boat.php', 'collections' => ['salt-and-sun']],
    'portrait-tied-to-boat' => ['file' => 'portrait-tied-to-boat.php', 'collections' => ['salt-and-sun']],
    'goth-bike-girl' => ['file' => 'goth-bike-girl.php', 'collections' => ['on-the-move']],
    'bb-chair' => ['file' => 'bb-chair.php', 'collections' => ['home']],
    'white-linen' => ['file' => 'white-linen.php', 'collections' => ['home']],
    'archery' => ['file' => 'archery.php', 'collections' => ['on-the-move']],
    'st-girl' => ['file' => 'st-girl.php', 'collections' => ['after-dark']],
    'leopard-mommy' => ['file' => 'leopard-mommy.php', 'collections' => ['after-dark']],
    'goddess-one' => ['file' => 'goddess-one.php', 'collections' => ['after-dark']],
    'food-and-boobs' => ['file' => 'food-and-boobs.php', 'collections' => ['after-dark']],
    'versace-mansion' => ['file' => 'versace-mansion.php', 'collections' => ['after-dark']],
    'pasta-girl' => ['file' => 'pasta-girl.php', 'collections' => ['after-dark']],
    'tiff-wedding' => ['file' => 'tiff-wedding.php', 'collections' => ['after-dark']],
    'throne-wide' => ['file' => 'throne-wide.php', 'collections' => ['after-dark']],
    'lipfille' => ['file' => 'lipfille.php', 'collections' => ['after-dark']],
    'dinner-potpie' => ['file' => 'dinner-potpie.php', 'collections' => ['after-dark']],
    'atv-babe' => ['file' => 'atv-babe.php', 'collections' => ['on-the-move']],
    'bridge' => ['file' => 'bridge.php', 'collections' => ['on-the-move']],
    'escargot' => ['file' => 'escargot.php', 'collections' => ['on-the-move']],
    'paris-train' => ['file' => 'paris-train.php', 'collections' => ['on-the-move']],
    'miami-elevator' => ['file' => 'miami-elevator.php', 'collections' => ['salt-and-sun']],
    'onepiece-girl' => ['file' => 'onepiece-girl.php', 'collections' => ['salt-and-sun']],
    'space-buns' => ['file' => 'space-buns.php', 'collections' => ['salt-and-sun']],
    'tulum-headscarf' => ['file' => 'tulum-headscarf.php', 'collections' => ['salt-and-sun']],
    'devotion-12' => ['file' => 'devotion-12.php', 'collections' => ['devotions']],
    'devotion-8' => ['file' => 'devotion-8.php', 'collections' => ['devotions']],
    'devotion-13' => ['file' => 'devotion-13.php', 'collections' => ['devotions']],
    'devotion-11' => ['file' => 'devotion-11.php', 'collections' => ['devotions']],
    'devotion-10' => ['file' => 'devotion-10.php', 'collections' => ['devotions']],
    'devotion-9' => ['file' => 'devotion-9.php', 'collections' => ['devotions']],
    'devotion-7' => ['file' => 'devotion-7.php', 'collections' => ['devotions']],
    'devotion-6' => ['file' => 'devotion-6.php', 'collections' => ['devotions']],
    'devotion-4' => ['file' => 'devotion-4.php', 'collections' => ['devotions']],
    'devotion-3' => ['file' => 'devotion-3.php', 'collections' => ['devotions']],
    'devotion-2' => ['file' => 'devotion-2.php', 'collections' => ['devotions']],
    'devotion-1' => ['file' => 'devotion-1.php', 'collections' => ['devotions']],
    'devotion-condo' => ['file' => 'devotion-condo.php', 'collections' => ['devotions']],
];

$id = (string) ($_GET['id'] ?? '');
$collection = (string) ($_GET['collection'] ?? '');
if (!isset($assets[$id], $collections[$collection]) || !in_array($collection, $assets[$id]['collections'], true)) {
    http_response_code(404);
    exit('Image not found.');
}

if (($_SESSION[$collections[$collection]] ?? false) !== true) {
    http_response_code(403);
    exit('Private image access required.');
}

$path = ($assets[$id]['prefixed'] ?? true)
    ? __DIR__ . '/private-images/' . $assets[$id]['file']
    : __DIR__ . '/' . $assets[$id]['file'];
$prefix = "<?php exit; ?>\n";
$handle = fopen($path, 'rb');
if ($handle === false || (($assets[$id]['prefixed'] ?? true) && fread($handle, strlen($prefix)) !== $prefix)) {
    http_response_code(500);
    exit('Image unavailable.');
}

header('Content-Type: image/jpeg');
header('Cache-Control: private, no-store');
fpassthru($handle);
