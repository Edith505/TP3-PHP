<?php
require_once __DIR__ . '/functions_cours.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_cours = $_POST['numero_cours'] ?? null;
    $titre = $_POST['titre'] ?? null;

    $erreurs = validerCours($numero_cours, $titre);

    if (empty($erreurs)) {
        ajouterCours(trim($numero_cours), trim($titre));
        header("Location: cours.php");
        exit;
    }
}

header("Location: cours.php");
exit;