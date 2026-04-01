<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class CategoryRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM categories ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    public function findByReviewId(int $reviewId): array
    {
        $sql = 'SELECT c.*
                FROM categories c
                INNER JOIN review_category rc ON rc.category_id = c.id
                WHERE rc.review_id = :review_id
                ORDER BY c.name ASC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['review_id' => $reviewId]);
        return $stmt->fetchAll();
    }

    public function syncForReview(int $reviewId, array $categoryIds): void
    {
        $deleteStmt = $this->pdo->prepare('DELETE FROM review_category WHERE review_id = :review_id');
        $deleteStmt->execute(['review_id' => $reviewId]);

        if ($categoryIds === []) {
            return;
        }

        $insertStmt = $this->pdo->prepare(
            'INSERT INTO review_category (review_id, category_id) VALUES (:review_id, :category_id)'
        );

        foreach ($categoryIds as $categoryId) {
            $insertStmt->execute([
                'review_id' => $reviewId,
                'category_id' => (int) $categoryId,
            ]);
        }
    }
}
