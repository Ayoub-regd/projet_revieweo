<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Repositories\ReviewRepository;

class ReviewService
{
    public function __construct(
        private readonly ReviewRepository $reviews = new ReviewRepository(),
        private readonly CategoryRepository $categories = new CategoryRepository()
    ) {
    }

    public function validatePayload(string $title, string $content, int $rating): array
    {
        $errors = [];

        if (trim($title) === '') {
            $errors[] = 'Le titre est obligatoire.';
        }

        if (trim($content) === '') {
            $errors[] = 'Le contenu est obligatoire.';
        }

        if ($rating < 1 || $rating > 10) {
            $errors[] = 'La note doit etre comprise entre 1 et 10.';
        }

        return $errors;
    }

    public function createWithCategories(
        int $userId,
        string $title,
        string $content,
        int $rating,
        array $categoryIds
    ): int {
        $reviewId = $this->reviews->create($userId, $title, $content, $rating);
        $this->categories->syncForReview($reviewId, $categoryIds);
        return $reviewId;
    }

    public function updateOwnedReviewWithCategories(
        int $reviewId,
        int $userId,
        string $title,
        string $content,
        int $rating,
        array $categoryIds
    ): bool {
        $updated = $this->reviews->updateByOwner($reviewId, $userId, $title, $content, $rating);
        if (!$updated) {
            return false;
        }

        $this->categories->syncForReview($reviewId, $categoryIds);
        return true;
    }

    /**
     * Auteur : update par proprietaire. Admin : update direct (comme la moderation en salle).
     */
    public function updateReviewWithCategoriesForActor(
        int $reviewId,
        int $actorId,
        string $actorRole,
        string $title,
        string $content,
        int $rating,
        array $categoryIds
    ): bool {
        if ($actorRole === 'admin') {
            $updated = $this->reviews->updateById($reviewId, $title, $content, $rating);
        } else {
            $updated = $this->reviews->updateByOwner($reviewId, $actorId, $title, $content, $rating);
        }

        if (!$updated) {
            return false;
        }

        $this->categories->syncForReview($reviewId, $categoryIds);
        return true;
    }

    public function deleteReview(int $reviewId, int $userId, string $role): bool
    {
        if ($role === 'admin') {
            return $this->reviews->deleteById($reviewId);
        }

        return $this->reviews->deleteByOwner($reviewId, $userId);
    }
}
