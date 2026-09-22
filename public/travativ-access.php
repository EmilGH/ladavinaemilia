<?php
/**
 * Access to the private collections.
 *
 * Who may see what is decided in Travativ, per person. This file translates
 * that decision into the session flags the rest of the site already reads, so
 * album.php, index.php and image.php did not have to change.
 *
 * Include it near the top of any page that gates something, after session_start().
 */
declare(strict_types=1);

require_once __DIR__ . '/travativ-config.php';
require_once __DIR__ . '/travativ-guard.php';

/** Collection slug in Travativ => the session flag this site already uses. */
const EMILIA_COLLECTIONS = [
    'home'         => 'emilia_home_photo_access',
    'devotions'    => 'emilia_devotions_photo_access',
    'salt-and-sun' => 'emilia_salt_and_sun_photo_access',
    'on-the-move'  => 'emilia_on_the_move_photo_access',
    'after-dark'   => 'emilia_after_dark_photo_access',
];

/**
 * Pick up a returning visitor and mirror their access into the old flags.
 *
 * travativ_allows() consumes the token if this request is carrying one, then
 * redirects to the clean URL — so this runs before any output.
 */
function emilia_sync_access(): void
{
    foreach (EMILIA_COLLECTIONS as $area => $flag) {
        if (travativ_allows($area)) {
            $_SESSION[$flag] = true;
        }
    }
}

/** Where to send someone who wants into a collection. */
function emilia_gate_url(string $collection, ?string $return = null): string
{
    if (!isset(EMILIA_COLLECTIONS[$collection])) $collection = 'home';
    return travativ_gate_url($collection, $return);
}

emilia_sync_access();
