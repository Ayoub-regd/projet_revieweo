<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $this->url($path));
        exit;
    }

    protected function url(string $path = ''): string
    {
        $normalizedBase = rtrim(BASE_URL, '/');
        $normalizedPath = ltrim($path, '/');
        return $normalizedBase . '/index.php?url=' . $normalizedPath;
    }
}
