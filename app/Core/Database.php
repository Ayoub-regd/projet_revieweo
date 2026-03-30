<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    // on garde les identifiants privés poiur la securité

    private $host = "localhost";
    private $db_name = "revieweo";
    private $username = "root";
    private $password = "";
    private $conn; //l'objet PDO qui viendra s'installer dedans. Victor et Ilyass vous pourraient l'utiliser pour envoyer des requêtes SQL

    public function __construct() {
        $this->conn =null;

        try {
            // on crée la chaine de connexion (DSN)
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8";

            // on initialise la connexion 
            $this->conn = new PDO($dsn, $this->username, $this->password);

            // on dit a pdo de nous alerter en cas derreur sql 
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "Connexion réussie !"; // Juste pour le test, on l'enlèvera après

         } catch(\PDOException $exception){
            //Si ça rate alors on affiche le message derreur 
            echo "Erreur de connexion: " . $exception->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}