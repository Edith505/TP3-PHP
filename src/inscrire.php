<?php
global $pdo;
require 'db.php';

// todo : préparez la requête d'insertion puis exécutez-la
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_etudiant = isset($_POST['etudiant']) ? $_POST['etudiant'] : null;
    $id_cours = isset($_POST['cours']) ? $_POST['cours'] : null;
    $session = isset($_POST['session']) ? $_POST['session'] : null;
    $annee = isset($_POST['annee']) ? $_POST['annee'] : null;
    $note = !empty($_POST['note']) ? $_POST['note'] : null;

    if ($id_etudiant && $id_cours && $session && $annee) {
        $stmt = $pdo->prepare("
                INSERT INTO inscription (id_etudiant, id_cours, session, annee, note) 
                VALUES (:id_etudiant, :id_cours, :session, :annee, :note)
            ");
        $stmt->execute([
            ':id_etudiant' => $id_etudiant,
            ':id_cours' => $id_cours,
            ':session' => $session,
            ':annee' => $annee,
            ':note' => $note
        ]);
    }
}


header("Location: inscriptions.php");
