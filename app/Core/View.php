<?php

namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "Vue introuvable: $view";
            return;
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layouts/main.php';
    }
}
