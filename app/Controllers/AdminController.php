<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;

class AdminController extends Controller
{
    public function dashboard(): void
    {
        Auth::requireRole('admin');

        $this->view('admin/dashboard', [
            'title' => 'Dashboard admin',
        ]);
    }
}
