<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\LikeRepository;
use App\Repositories\ReviewRepository;

/**
 * Controleur public des critiques (liste + detail), meme idee que ArticleController en TP.
 */
class ReviewController extends Controller
{
    private ReviewRepository $reviews;
    private CategoryRepository $categories;
    private LikeRepository $likes;

    public function __construct()
    {
        $this->reviews = new ReviewRepository();
        $this->categories = new CategoryRepository();
        $this->likes = new LikeRepository();
    }

    public function index(): void
    {
        // Filtre GET optionnel, comme un $_GET['id'] en TP mais pour la categorie
        $categoryId = isset($_GET['category']) ? (int) $_GET['category'] : null;
        if ($categoryId === 0) {
            $categoryId = null;
        }

        $list = $this->reviews->findAllWithLikeCounts($categoryId);
        $allCategories = $this->categories->findAll();

        $rows = [];
        foreach ($list as $row) {
            $rows[] = [
                'review' => $row,
                'categories' => $this->categories->findByReviewId((int) $row['id']),
            ];
        }

        $this->view('review/index', [
            'title' => 'Critiques',
            'rows' => $rows,
            'categories' => $allCategories,
            'filterCategoryId' => $categoryId,
        ]);
    }

    public function show(string $id): void
    {
        $reviewId = (int) $id;
        if ($reviewId < 1) {
            http_response_code(404);
            echo '<h1>404</h1><p>Critique introuvable.</p>';
            return;
        }

        $review = $this->reviews->findById($reviewId);
        if (!$review) {
            http_response_code(404);
            echo '<h1>404</h1><p>Critique introuvable.</p>';
            return;
        }

        $reviewCategories = $this->categories->findByReviewId($reviewId);
        $likesCount = $this->likes->countByReviewId($reviewId);

        $uid = Auth::id();
        $userLiked = $uid !== null && $this->likes->exists($uid, $reviewId);

        $this->view('review/show', [
            'title' => $review['title'],
            'review' => $review,
            'reviewCategories' => $reviewCategories,
            'likesCount' => $likesCount,
            'userLiked' => $userLiked,
            'extraScripts' => ['assets/js/like.js'],
        ]);
    }
}

