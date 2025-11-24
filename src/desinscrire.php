<?php
global $pdo;
require 'db.php';

// todo : récupérez les infos id d'une inscription
$id_etudiant = isset($_GET['id_etudiant']) ? $_GET['id_etudiant'] : null;
$id_cours = isset($_GET['id_cours']) ? $_GET['id_cours'] : null;
$session = isset($_GET['session']) ? $_GET['session'] : null;
$annee = isset($_GET['annee']) ? $_GET['annee'] : null;

if ($id_etudiant && $id_cours && $session && $annee) {
    $stmt = $pdo->prepare("
        DELETE FROM inscription 
        WHERE id_etudiant = :id_etudiant 
        AND id_cours = :id_cours
        AND session = :session
        AND annee = :annee
    ");
    $stmt->execute([
        ':id_etudiant' => $id_etudiant,
        ':id_cours' => $id_cours,
        ':session' => $session,
        ':annee' => $annee
    ]);
}

header("Location: inscriptions.php");
