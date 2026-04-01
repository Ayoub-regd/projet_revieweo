<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getConnection();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /** Liste pour l'admin (pas de mot de passe affiche dans la vue). */
    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT id, username, email, role, created_at FROM users ORDER BY id ASC'
        );
        return $stmt->fetchAll();
    }

    public function updateRole(int $id, string $role): bool
    {
        $stmt = $this->pdo->prepare('UPDATE users SET role = :role WHERE id = :id');
        return $stmt->execute(['role' => $role, 'id' => $id]);
    }

    public function create(string $username, string $email, string $passwordHash, string $role = 'user'): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)'
        );

        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $passwordHash,
            'role' => $role,
        ]);
    }
}
