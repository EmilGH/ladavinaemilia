<?php
/**
 * Travativ Content Access — drop-in guard for PHP sites.
 *
 * One file, no dependencies, PHP 8.0+. Copy it next to your pages, set the
 * two constants below from your Travativ site settings, and call
 * travativ_require() at the top of anything you want gated.
 *
 *     require __DIR__ . '/travativ-guard.php';
 *     travativ_require('after-dark');
 *
 * Or, to render a teaser instead of redirecting:
 *
 *     if (travativ_allows('after-dark')) { ... } else { ... link to travativ_gate_url('after-dark') ... }
 *
 * The guard keeps its own PHP session flag once someone is let in, so there is
 * exactly one round trip per visitor per session — not one per page.
 *
 * Version 1.0.0 · https://travativ.com
 */

declare(strict_types=1);

// ─── settings ────────────────────────────────────────────────────────────
// Both values come from Travativ → Content Access → your site.
if (!defined('TRAVATIV_SITE_KEY')) define('TRAVATIV_SITE_KEY', '');
if (!defined('TRAVATIV_SECRET'))   define('TRAVATIV_SECRET', '');
if (!defined('TRAVATIV_BASE'))     define('TRAVATIV_BASE', 'https://travativ.com');

// Where the flag is stored. Defaults to a name of the guard's own; override it
// to match session keys a site is already using.
if (!defined('TRAVATIV_SESSION_PREFIX')) define('TRAVATIV_SESSION_PREFIX', 'travativ_access_');

/** Allowed clock drift, in seconds, between this server and Travativ. */
if (!defined('TRAVATIV_SKEW')) define('TRAVATIV_SKEW', 60);
// ─────────────────────────────────────────────────────────────────────────


function travativ_session_key(string $area): string
{
    return TRAVATIV_SESSION_PREFIX . preg_replace('/[^a-z0-9_]+/', '_', strtolower($area));
}

function travativ__start_session(): void
{
    if (session_status() === PHP_SESSION_NONE) session_start();
}

function travativ__b64url_decode(string $s): string|false
{
    $pad = strlen($s) % 4;
    if ($pad) $s .= str_repeat('=', 4 - $pad);
    return base64_decode(strtr($s, '-_', '+/'), true);
}

/** The full URL of the current request, for coming back to. */
function travativ_current_url(): string
{
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
          || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $uri  = $_SERVER['REQUEST_URI'] ?? '/';

    // Drop our own parameters so the address bar ends up clean.
    $parts = parse_url($uri);
    $path  = $parts['path'] ?? '/';
    parse_str($parts['query'] ?? '', $q);
    unset($q['tv_token'], $q['tv_state']);
    $qs = $q ? '?' . http_build_query($q) : '';

    return ($https ? 'https' : 'http') . '://' . $host . $path . $qs;
}

/** Where to send someone who needs to prove who they are. */
function travativ_gate_url(string $area, ?string $return = null): string
{
    travativ__start_session();
    $state = bin2hex(random_bytes(12));
    $_SESSION['travativ_state'] = $state;

    return rtrim(TRAVATIV_BASE, '/') . '/access/'
         . rawurlencode(TRAVATIV_SITE_KEY) . '/' . rawurlencode($area)
         . '?return=' . rawurlencode($return ?? travativ_current_url())
         . '&state=' . rawurlencode($state);
}

/**
 * Consume a handshake token if one is on this request.
 * Safe to call on every page; does nothing when there is no token.
 */
function travativ_handle_callback(): bool
{
    if (empty($_GET['tv_token']) || empty($_GET['tv_state'])) return false;
    travativ__start_session();

    $token = (string) $_GET['tv_token'];
    $state = (string) $_GET['tv_state'];

    // The state we issued must be the state that came back: a token pasted in
    // from somewhere else has no matching session entry.
    $expected = (string) ($_SESSION['travativ_state'] ?? '');
    unset($_SESSION['travativ_state']);
    if ($expected === '' || !hash_equals($expected, $state)) return false;

    $parts = explode('.', $token);
    if (count($parts) !== 2) return false;
    [$b64, $sig] = $parts;

    $want = rtrim(strtr(base64_encode(
        hash_hmac('sha256', $b64, TRAVATIV_SECRET, true)
    ), '+/', '-_'), '=');
    if (!hash_equals($want, $sig)) return false;           // not signed by us

    $json = travativ__b64url_decode($b64);
    if ($json === false) return false;
    $p = json_decode($json, true);
    if (!is_array($p) || ($p['v'] ?? 0) !== 1) return false;

    $now = time();
    if (($p['exp'] ?? 0) + TRAVATIV_SKEW < $now) return false;          // stale
    if (($p['iat'] ?? 0) - TRAVATIV_SKEW > $now) return false;          // future
    if (!hash_equals($state, (string) ($p['state'] ?? ''))) return false;
    if (empty($p['area'])) return false;

    $_SESSION[travativ_session_key((string) $p['area'])] = true;
    $_SESSION['travativ_sub'] = (string) ($p['sub'] ?? '');
    return true;
}

/** Has this visitor already been let into this area? */
function travativ_allows(string $area): bool
{
    travativ__start_session();
    if (travativ_handle_callback()) {
        // Reload without the token in the URL so a refresh or a shared link
        // does not carry it around.
        header('Location: ' . travativ_current_url(), true, 302);
        exit;
    }
    return ($_SESSION[travativ_session_key($area)] ?? false) === true;
}

/** Require access, sending them to Travativ if they do not have it. */
function travativ_require(string $area): void
{
    if (travativ_allows($area)) return;
    header('Location: ' . travativ_gate_url($area), true, 302);
    exit;
}

/** An opaque, per-site id for the current visitor. Stable; not their email. */
function travativ_visitor(): ?string
{
    travativ__start_session();
    $v = $_SESSION['travativ_sub'] ?? '';
    return $v !== '' ? (string) $v : null;
}

/** Forget this visitor's access on this site only. */
function travativ_forget(): void
{
    travativ__start_session();
    foreach (array_keys($_SESSION) as $k) {
        if (str_starts_with((string) $k, TRAVATIV_SESSION_PREFIX)) unset($_SESSION[$k]);
    }
    unset($_SESSION['travativ_sub']);
}
