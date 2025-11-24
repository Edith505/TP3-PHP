<?php
global $pdo;
require 'db.php';


// todo : Récupérez les valeurs d'un étudiant,
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $courriel = trim($_POST['courriel']);

    if (!empty($nom) && !empty($courriel)) {
        $stmt = $pdo->prepare("INSERT INTO etudiant (nom, courriel) VALUES (:nom, :courriel)");
        $stmt->execute([
            ':nom' => $nom,
            ':courriel' => $courriel
        ]);
    }
}

header("Location: etudiants.php");
