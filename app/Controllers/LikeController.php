<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Services\LikeService;

/**
 * Endpoint JSON pour le like AJAX (fetch cote navigateur).
 */
class LikeController extends Controller
{
    public function toggle(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['ok' => false, 'message' => 'Methode non autorisee.']);
            return;
        }

        $reviewId = (int) ($_POST['review_id'] ?? 0);
        if ($reviewId < 1) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'message' => 'Critique invalide.']);
            return;
        }

        $service = new LikeService();
        $result = $service->toggleForUser(Auth::id(), $reviewId);

        if (!$result['ok']) {
            http_response_code(401);
            echo json_encode($result);
            return;
        }

        echo json_encode($result);
    }
}
