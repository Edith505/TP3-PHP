<?php
global $pdo;
require 'db.php';

// todo : Récupérez les valeurs du cours,
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_cours = trim($_POST['cours']);
    $titre = trim($_POST['titre_cours']);

    if (!empty($numero_cours) && !empty($titre)) {
        $stmt = $pdo->prepare("INSERT INTO cours (numero_cours, titre) VALUES (:numero_cours, :titre)");
        $stmt->execute([
            ':numero_cours' => $numero_cours,
            ':titre' => $titre
        ]);
    }
}

header("Location: cours.php");
