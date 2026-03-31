<?php

namespace App\Core;

class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user']) && is_array($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return self::check() ? $_SESSION['user'] : null;
    }

    public static function id(): ?int
    {
        if (!self::check() || !isset($_SESSION['user']['id'])) {
            return null;
        }

        return (int) $_SESSION['user']['id'];
    }

    public static function role(): ?string
    {
        if (!self::check() || !isset($_SESSION['user']['role'])) {
            return null;
        }

        return (string) $_SESSION['user']['role'];
    }

    public static function hasRole(string|array $roles): bool
    {
        if (!self::check()) {
            return false;
        }

        $allowedRoles = is_array($roles) ? $roles : [$roles];

        return in_array(self::role(), $allowedRoles, true);
    }

    public static function requireLogin(string $redirect = 'auth/login'): void
    {
        if (self::check()) {
            return;
        }

        $_SESSION['flash_error'] = 'Veuillez vous connecter.';
        self::redirect($redirect);
    }

    public static function requireRole(string|array $roles, string $redirect = 'home/index'): void
    {
        if (!self::check()) {
            $_SESSION['flash_error'] = 'Veuillez vous connecter.';
            self::redirect('auth/login');
        }

        if (self::hasRole($roles)) {
            return;
        }

        $_SESSION['flash_error'] = 'Acces refuse.';
        self::redirect($redirect);
    }

    public static function logout(string $flashMessage = 'Vous etes deconnecte.'): void
    {
        $cookieParams = session_get_cookie_params();

        unset($_SESSION['user']);

        $_SESSION = [];

        if (session_status() === PHP_SESSION_ACTIVE) {
            if (ini_get('session.use_cookies')) {
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $cookieParams['path'],
                    $cookieParams['domain'],
                    (bool) $cookieParams['secure'],
                    (bool) $cookieParams['httponly']
                );
            }

            session_destroy();
        }

        if (session_status() !== PHP_SESSION_ACTIVE && !headers_sent()) {
            session_start([
                'use_only_cookies' => 1,
                'use_strict_mode' => 1,
                'cookie_httponly' => 1,
                'cookie_samesite' => 'Lax',
            ]);
        }

        $_SESSION['flash_success'] = $flashMessage;
    }

    private static function redirect(string $path): void
    {
        $baseUrl = defined('BASE_URL') ? rtrim((string) BASE_URL, '/') : '';
        $normalizedPath = ltrim($path, '/');

        header('Location: ' . $baseUrl . '/index.php?url=' . $normalizedPath);
        exit;
    }
}
