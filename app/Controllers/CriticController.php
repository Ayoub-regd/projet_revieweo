<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;

class CriticController extends Controller
{
    public function dashboard(): void
    {
        Auth::requireRole('critique');

        $this->view('critic/dashboard', [
            'title' => 'Dashboard critique',
        ]);
    }

    public function create(): void
    {
        Auth::requireRole('critique');

        $this->view('critic/create', [
            'title' => 'Creer une critique',
        ]);
    }

    public function edit(): void
    {
        Auth::requireRole('critique');

        $this->view('critic/edit', [
            'title' => 'Modifier une critique',
        ]);
    }
}
