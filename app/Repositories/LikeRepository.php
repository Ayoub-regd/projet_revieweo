<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class LikeRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    public function countByReviewId(int $reviewId): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM likes WHERE review_id = :review_id');
        $stmt->execute(['review_id' => $reviewId]);
        return (int) $stmt->fetchColumn();
    }

    public function exists(int $userId, int $reviewId): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT 1 FROM likes WHERE user_id = :user_id AND review_id = :review_id LIMIT 1'
        );
        $stmt->execute([
            'user_id' => $userId,
            'review_id' => $reviewId,
        ]);

        return (bool) $stmt->fetchColumn();
    }

    public function like(int $userId, int $reviewId): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT IGNORE INTO likes (user_id, review_id) VALUES (:user_id, :review_id)'
        );
        $stmt->execute([
            'user_id' => $userId,
            'review_id' => $reviewId,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function unlike(int $userId, int $reviewId): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM likes WHERE user_id = :user_id AND review_id = :review_id'
        );
        $stmt->execute([
            'user_id' => $userId,
            'review_id' => $reviewId,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function toggle(int $userId, int $reviewId): bool
    {
        if ($this->exists($userId, $reviewId)) {
            $this->unlike($userId, $reviewId);
            return false;
        }

        $this->like($userId, $reviewId);
        return true;
    }
}
