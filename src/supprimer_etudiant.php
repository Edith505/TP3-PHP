<?php
require_once __DIR__ . '/functions_etudiant.php';

$id = $_GET['id'] ?? null;
if ($id) {
    supprimerEtudiant((int)$id);
}

header("Location: etudiants.php");
exit;