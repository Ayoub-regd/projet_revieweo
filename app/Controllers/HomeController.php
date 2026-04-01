<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\ReviewRepository;

class HomeController extends Controller
{
    public function index(): void
    {
        $reviews = new ReviewRepository();
        $categories = new CategoryRepository();

        $featured = $reviews->findRecentForHome(6);
        $featuredRows = [];
        foreach ($featured as $row) {
            $featuredRows[] = [
                'review' => $row,
                'categories' => $categories->findByReviewId((int) $row['id']),
            ];
        }

        $this->view('home/index', [
            'title' => 'Accueil',
            'featuredRows' => $featuredRows,
        ]);
    }
}
