<?php
declare(strict_types=1);
session_start();

if (($_SESSION['emilia_photo_access'] ?? false) !== true) {
    http_response_code(403);
    exit('Private image access required.');
}

$assets = [
    'hero' => 'hero.php',
    'about' => 'about.php',
    'travel' => 'travel.php',
    'boat' => 'boat.php',
    'table' => 'table.php',
    'opera' => 'opera.php',
    'alux' => 'alux.php',
    'twa' => 'twa.php',
    'scuba' => 'scuba.php',
    'nola-pink' => 'nola-pink.php',
    'nola-streetlight' => 'nola-streetlight.php',
    'horse' => 'horse.php',
    'wings-cosumel' => 'wings-cosumel.php',
    'workout' => 'workout.php',
    'tied-to-boat' => 'tied-to-boat.php',
    'portrait-tied-to-boat' => 'portrait-tied-to-boat.php',
    'goth-bike-girl' => 'goth-bike-girl.php',
];
$id = (string) ($_GET['id'] ?? '');
if (!isset($assets[$id])) {
    http_response_code(404);
    exit('Image not found.');
}

$path = __DIR__ . '/private-images/' . $assets[$id];
$prefix = "<?php exit; ?>\n";
$handle = fopen($path, 'rb');
if ($handle === false || fread($handle, strlen($prefix)) !== $prefix) {
    http_response_code(500);
    exit('Image unavailable.');
}

header('Content-Type: image/jpeg');
header('Cache-Control: private, no-store');
fpassthru($handle);
