<?php

namespace App\Services;

use App\Repositories\LikeRepository;

class LikeService
{
    public function __construct(private readonly LikeRepository $likes = new LikeRepository())
    {
    }

    public function toggleForUser(?int $userId, int $reviewId): array
    {
        if ($userId === null) {
            return [
                'ok' => false,
                'message' => 'Connexion requise.',
                'liked' => false,
                'count' => $this->likes->countByReviewId($reviewId),
            ];
        }

        $liked = $this->likes->toggle($userId, $reviewId);

        return [
            'ok' => true,
            'message' => $liked ? 'Like ajoute.' : 'Like retire.',
            'liked' => $liked,
            'count' => $this->likes->countByReviewId($reviewId),
        ];
    }
}
