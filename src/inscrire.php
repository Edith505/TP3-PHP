<?php
require_once __DIR__ . '/functions_inscription.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_etudiant = $_POST['etudiant'] ?? null;
    $id_cours = $_POST['cours'] ?? null;
    $session = $_POST['session'] ?? null;
    $annee = $_POST['annee'] ?? null;
    $noteStr = $_POST['note'] ?? null;

    [$erreurs, $note] = validerInscription($id_etudiant, $id_cours, $session, $annee, $noteStr);

    if (empty($erreurs)) {
        try {
            ajouterInscription((int)$id_etudiant, (int)$id_cours, $session, (int)$annee, $note);
        } catch (PDOException $e) {
            // Inscription existe déjà
        }
    }
}

header("Location: inscriptions.php");
exit;