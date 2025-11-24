<?php
require_once __DIR__ . '/functions_cours.php';

$id = $_GET['id'] ?? null;
if ($id) {
    supprimerCours((int)$id);
}

header("Location: cours.php");
exit;
