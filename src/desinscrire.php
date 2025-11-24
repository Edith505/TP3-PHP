<?php
require_once __DIR__ . '/functions_inscription.php';

$id_etudiant = $_GET['id_etudiant'] ?? null;
$id_cours = $_GET['id_cours'] ?? null;

if ($id_etudiant && $id_cours) {
    supprimerInscription((int)$id_etudiant, (int)$id_cours);
}

header("Location: inscriptions.php");
exit;