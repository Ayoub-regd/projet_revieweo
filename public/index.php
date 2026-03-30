<?php

/**
 * REVIEWEO - Front Controller
 * Auteur : Ayoub
 */


// 1. Configuration et affichage des erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// 2. L'autoloader (Indispensable AVANT d'appeler une classe)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require_once $file;
});

// 3. MAINTENANT on teste la base de données
use App\Core\Database;

$database = new Database();
$db = $database->getConnection();

echo "--- Résultat du test ---<br>";
var_dump($db);