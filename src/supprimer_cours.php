<?php
require 'db.php';
// todo : récupérez le id d'un cours
$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM cours WHERE id = :id");
    $stmt->execute([':id' => $id]);
}


header("Location: cours.php");
