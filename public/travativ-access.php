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

/**
 * The config holds the signing secret and is deliberately not in the repo, so
 * it can be absent on a fresh deploy. A missing or half-filled config must
 * leave every collection closed — never take the site down with it.
 */
if (is_readable(__DIR__ . '/travativ-config.php')) {
    require_once __DIR__ . '/travativ-config.php';
}
require_once __DIR__ . '/travativ-guard.php';

function emilia_access_configured(): bool
{
    return defined('TRAVATIV_SITE_KEY') && TRAVATIV_SITE_KEY !== ''
        && defined('TRAVATIV_SECRET')   && TRAVATIV_SECRET !== ''
        && TRAVATIV_SECRET !== 'paste-the-secret-here';
}

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
    if (!emilia_access_configured()) return;

    foreach (EMILIA_COLLECTIONS as $area => $flag) {
        if (travativ_allows($area)) {
            $_SESSION[$flag] = true;
        }
    }
}

/** Where to send someone who wants into a collection. */
function emilia_gate_url(string $collection, ?string $return = null): string
{
    if (!emilia_access_configured()) return '/gate.php';
    if (!isset(EMILIA_COLLECTIONS[$collection])) $collection = 'home';
    return travativ_gate_url($collection, $return);
}

emilia_sync_access();
