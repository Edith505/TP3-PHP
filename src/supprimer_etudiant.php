<?php
require 'db.php';
// todo : récupérez le id d'un etudiant
$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM etudiant WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header("Location: etudiants.php");
