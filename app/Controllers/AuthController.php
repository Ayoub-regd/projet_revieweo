<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    private UserRepository $users;

    public function __construct()
    {
        $this->users = new UserRepository();
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = (string) ($_POST['password'] ?? '');

            if ($email === '' || $password === '') {
                $_SESSION['flash_error'] = 'Veuillez remplir tous les champs.';
                $this->redirect('auth/login');
            }

            $user = $this->users->findByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                $_SESSION['flash_error'] = 'Email ou mot de passe invalide.';
                $this->redirect('auth/login');
            }

            $_SESSION['user'] = [
                'id' => (int) $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
            ];
            $_SESSION['flash_success'] = 'Connexion reussie.';
            $this->redirect('home/index');
        }

        $this->view('auth/login', ['title' => 'Connexion']);
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = (string) ($_POST['password'] ?? '');
            $passwordConfirm = (string) ($_POST['password_confirm'] ?? '');

            if ($username === '' || $email === '' || $password === '' || $passwordConfirm === '') {
                $_SESSION['flash_error'] = 'Tous les champs sont obligatoires.';
                $this->redirect('auth/register');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash_error'] = 'Email invalide.';
                $this->redirect('auth/register');
            }

            if (strlen($password) < 6) {
                $_SESSION['flash_error'] = 'Le mot de passe doit contenir au moins 6 caracteres.';
                $this->redirect('auth/register');
            }

            if ($password !== $passwordConfirm) {
                $_SESSION['flash_error'] = 'Les mots de passe ne correspondent pas.';
                $this->redirect('auth/register');
            }

            if ($this->users->findByEmail($email)) {
                $_SESSION['flash_error'] = 'Cet email est deja utilise.';
                $this->redirect('auth/register');
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $this->users->create($username, $email, $hash, 'user');

            $_SESSION['flash_success'] = 'Compte cree, vous pouvez vous connecter.';
            $this->redirect('auth/login');
        }

        $this->view('auth/register', ['title' => 'Inscription']);
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        $_SESSION['flash_success'] = 'Vous etes deconnecte.';
        $this->redirect('home/index');
    }
}
