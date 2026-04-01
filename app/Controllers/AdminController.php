<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;

/**
 * Moderation : reservé au role admin (liste, epingle, suppression, roles utilisateurs).
 */
class AdminController extends Controller
{
    private ReviewRepository $reviews;
    private UserRepository $users;
    private CategoryRepository $categories;

    public function __construct()
    {
        $this->reviews = new ReviewRepository();
        $this->users = new UserRepository();
        $this->categories = new CategoryRepository();
    }

    public function dashboard(): void
    {
        Auth::requireRole('admin');

        $allReviews = $this->reviews->findAll();
        $reviewRows = [];
        foreach ($allReviews as $r) {
            $reviewRows[] = [
                'review' => $r,
                'categories' => $this->categories->findByReviewId((int) $r['id']),
            ];
        }

        $allUsers = $this->users->findAll();

        $this->view('admin/dashboard', [
            'title' => 'Administration',
            'reviewRows' => $reviewRows,
            'users' => $allUsers,
        ]);
    }

    public function togglePin(): void
    {
        Auth::requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/dashboard');
        }

        $reviewId = (int) ($_POST['review_id'] ?? 0);
        if ($reviewId < 1) {
            $_SESSION['flash_error'] = 'Critique invalide.';
            $this->redirect('admin/dashboard');
        }

        $review = $this->reviews->findById($reviewId);
        if (!$review) {
            $_SESSION['flash_error'] = 'Critique introuvable.';
            $this->redirect('admin/dashboard');
        }

        $current = (int) ($review['is_pinned'] ?? 0) === 1;
        $this->reviews->setPinned($reviewId, !$current);
        $_SESSION['flash_success'] = $current ? 'Critique desepinglee.' : 'Critique epinglee.';
        $this->redirect('admin/dashboard');
    }

    public function deleteReview(): void
    {
        Auth::requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/dashboard');
        }

        $reviewId = (int) ($_POST['review_id'] ?? 0);
        if ($reviewId < 1) {
            $_SESSION['flash_error'] = 'Critique invalide.';
            $this->redirect('admin/dashboard');
        }

        $deleted = $this->reviews->deleteById($reviewId);
        $_SESSION['flash_success'] = $deleted ? 'Critique supprimee.' : 'Suppression impossible.';
        $this->redirect('admin/dashboard');
    }

    public function setUserRole(): void
    {
        Auth::requireRole('admin');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/dashboard');
        }

        $userId = (int) ($_POST['user_id'] ?? 0);
        $role = (string) ($_POST['role'] ?? '');
        $allowed = ['user', 'critique', 'admin'];

        if ($userId < 1 || !in_array($role, $allowed, true)) {
            $_SESSION['flash_error'] = 'Donnees invalides.';
            $this->redirect('admin/dashboard');
        }

        $currentId = Auth::id();
        if ($currentId !== null && $userId === $currentId && $role !== 'admin') {
            $_SESSION['flash_error'] = 'Vous ne pouvez pas retirer votre propre role administrateur.';
            $this->redirect('admin/dashboard');
        }

        $this->users->updateRole($userId, $role);
        $_SESSION['flash_success'] = 'Role mis a jour.';
        $this->redirect('admin/dashboard');
    }
}
