<?php
session_start();
require_once __DIR__ . '/functions_cours.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_cours = $_POST['numero_cours'] ?? null;
    $titre = $_POST['titre'] ?? null;

    $erreurs = validerCours($numero_cours, $titre);

    if (empty($erreurs)) {
        ajouterCours(trim($numero_cours), trim($titre));
        header("Location: cours.php");
        exit;
    } else {
        $_SESSION['erreurs'] = $erreurs;
        $_SESSION['old_data'] = $_POST;
    }
}

header("Location: cours.php");
exit;