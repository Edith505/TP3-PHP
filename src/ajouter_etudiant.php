<?php
session_start();
require_once __DIR__ . '/functions_etudiant.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? null;
    $courriel = $_POST['courriel'] ?? null;

    $erreurs = validerEtudiant($nom, $courriel);

    if (empty($erreurs)) {
        ajouterEtudiant(trim($nom), trim($courriel));
        header("Location: etudiants.php");
        exit;
    } else {
        $_SESSION['erreurs'] = $erreurs;
        $_SESSION['old_data'] = $_POST;
    }
}

header("Location: etudiants.php");
exit;