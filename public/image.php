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
