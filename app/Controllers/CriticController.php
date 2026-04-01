<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ReviewRepository;
use App\Services\ReviewService;

/**
 * Espace redacteur : meme logique qu'ArticleController en TP (auth + GET/POST + redirect).
 * Accessible aux roles critique et admin.
 */
class CriticController extends Controller
{
    private ReviewService $reviewService;
    private ReviewRepository $reviews;
    private CategoryRepository $categories;

    public function __construct()
    {
        $this->reviewService = new ReviewService();
        $this->reviews = new ReviewRepository();
        $this->categories = new CategoryRepository();
    }

    public function dashboard(): void
    {
        Auth::requireRole(['critique', 'admin']);

        $userId = Auth::id();
        if ($userId === null) {
            $this->redirect('auth/login');
        }

        $list = $this->reviews->findByUserId($userId);

        $this->view('critic/dashboard', [
            'title' => 'Mes critiques',
            'reviews' => $list,
        ]);
    }

    public function create(): void
    {
        Auth::requireRole(['critique', 'admin']);

        $categories = $this->categories->findAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $rating = (int) ($_POST['rating'] ?? 0);
            $catRaw = $_POST['categories'] ?? [];
            $categoryIds = is_array($catRaw) ? array_map('intval', $catRaw) : [];

            $errors = $this->reviewService->validatePayload($title, $content, $rating);
            if ($errors !== []) {
                $_SESSION['flash_error'] = implode(' ', $errors);
                $this->redirect('critic/create');
            }

            $userId = Auth::id();
            if ($userId === null) {
                $this->redirect('auth/login');
            }

            $this->reviewService->createWithCategories($userId, $title, $content, $rating, $categoryIds);
            $_SESSION['flash_success'] = 'Critique publiee.';
            $this->redirect('critic/dashboard');
        }

        $this->view('critic/create', [
            'title' => 'Nouvelle critique',
            'categories' => $categories,
        ]);
    }

    public function edit(string $id): void
    {
        Auth::requireRole(['critique', 'admin']);

        $reviewId = (int) $id;
        if ($reviewId < 1) {
            $_SESSION['flash_error'] = 'Critique invalide.';
            $this->redirect('critic/dashboard');
        }

        $review = $this->reviews->findById($reviewId);
        if (!$review) {
            $_SESSION['flash_error'] = 'Critique introuvable.';
            $this->redirect('critic/dashboard');
        }

        $actorId = Auth::id();
        $role = Auth::role();
        $isOwner = $actorId !== null && (int) $review['user_id'] === $actorId;
        $isAdmin = $role === 'admin';
        if (!$isOwner && !$isAdmin) {
            $_SESSION['flash_error'] = 'Acces refuse.';
            $this->redirect('critic/dashboard');
        }

        $categories = $this->categories->findAll();
        $selected = $this->categories->findByReviewId($reviewId);
        $selectedIds = array_map(static fn ($c) => (int) $c['id'], $selected);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $rating = (int) ($_POST['rating'] ?? 0);
            $catRaw = $_POST['categories'] ?? [];
            $categoryIds = is_array($catRaw) ? array_map('intval', $catRaw) : [];

            $errors = $this->reviewService->validatePayload($title, $content, $rating);
            if ($errors !== []) {
                $_SESSION['flash_error'] = implode(' ', $errors);
                $this->redirect('critic/edit/' . $reviewId);
            }

            if ($actorId === null || $role === null) {
                $this->redirect('auth/login');
            }

            $ok = $this->reviewService->updateReviewWithCategoriesForActor(
                $reviewId,
                $actorId,
                $role,
                $title,
                $content,
                $rating,
                $categoryIds
            );

            if (!$ok) {
                $_SESSION['flash_error'] = 'Mise a jour impossible.';
                $this->redirect('critic/edit/' . $reviewId);
            }

            $_SESSION['flash_success'] = 'Critique mise a jour.';
            $this->redirect('critic/dashboard');
        }

        $this->view('critic/edit', [
            'title' => 'Modifier la critique',
            'review' => $review,
            'categories' => $categories,
            'selectedCategoryIds' => $selectedIds,
        ]);
    }

    public function delete(): void
    {
        Auth::requireRole(['critique', 'admin']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('critic/dashboard');
        }

        $reviewId = (int) ($_POST['review_id'] ?? 0);
        if ($reviewId < 1) {
            $_SESSION['flash_error'] = 'Critique invalide.';
            $this->redirect('critic/dashboard');
        }

        $review = $this->reviews->findById($reviewId);
        if (!$review) {
            $_SESSION['flash_error'] = 'Critique introuvable.';
            $this->redirect('critic/dashboard');
        }

        $actorId = Auth::id();
        $role = Auth::role();
        $isOwner = $actorId !== null && (int) $review['user_id'] === $actorId;
        $isAdmin = $role === 'admin';
        if (!$isOwner && !$isAdmin) {
            $_SESSION['flash_error'] = 'Acces refuse.';
            $this->redirect('critic/dashboard');
        }

        if ($actorId === null || $role === null) {
            $this->redirect('auth/login');
        }

        $deleted = $this->reviewService->deleteReview($reviewId, $actorId, $role);
        $_SESSION['flash_success'] = $deleted ? 'Critique supprimee.' : 'Suppression impossible.';
        $this->redirect('critic/dashboard');
    }
}
