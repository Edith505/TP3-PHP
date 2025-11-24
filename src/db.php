<?php
$config = require 'config.php';

try {
    $pdo = new PDO(
        $config['dsn'],
        $config['user'],
        $config['pass'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Erreur connexion BD : " . $e->getMessage());
}
