<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class ReviewRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    public function findAll(): array
    {
        $sql = 'SELECT r.*, u.username
                FROM reviews r
                INNER JOIN users u ON u.id = r.user_id
                ORDER BY r.is_pinned DESC, r.created_at DESC';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $sql = 'SELECT r.*, u.username
                FROM reviews r
                INNER JOIN users u ON u.id = r.user_id
                WHERE r.id = :id
                LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $review = $stmt->fetch();
        return $review ?: null;
    }

    public function findByUserId(int $userId): array
    {
        $sql = 'SELECT *
                FROM reviews
                WHERE user_id = :user_id
                ORDER BY created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function create(int $userId, string $title, string $content, int $rating): int
    {
        $sql = 'INSERT INTO reviews (title, content, rating, user_id)
                VALUES (:title, :content, :rating, :user_id)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'content' => $content,
            'rating' => $rating,
            'user_id' => $userId,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function updateByOwner(int $reviewId, int $ownerId, string $title, string $content, int $rating): bool
    {
        $sql = 'UPDATE reviews
                SET title = :title, content = :content, rating = :rating
                WHERE id = :id AND user_id = :user_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'title' => $title,
            'content' => $content,
            'rating' => $rating,
            'id' => $reviewId,
            'user_id' => $ownerId,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function deleteByOwner(int $reviewId, int $ownerId): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM reviews WHERE id = :id AND user_id = :user_id');
        $stmt->execute([
            'id' => $reviewId,
            'user_id' => $ownerId,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function deleteById(int $reviewId): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM reviews WHERE id = :id');
        $stmt->execute(['id' => $reviewId]);

        return $stmt->rowCount() > 0;
    }

    public function setPinned(int $reviewId, bool $isPinned): bool
    {
        $stmt = $this->pdo->prepare('UPDATE reviews SET is_pinned = :is_pinned WHERE id = :id');
        $stmt->execute([
            'is_pinned' => $isPinned ? 1 : 0,
            'id' => $reviewId,
        ]);

        return $stmt->rowCount() > 0;
    }
}
