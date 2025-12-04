<?php
require_once __DIR__ . '/db.php';

function creerTableCours(): void
{
    global $pdo;
    $sql = "
    CREATE TABLE IF NOT EXISTS cours (
        id INT AUTO_INCREMENT PRIMARY KEY,
        numero_cours VARCHAR(7) NOT NULL UNIQUE,
        titre VARCHAR(150) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ";
    $pdo->exec($sql);
}

function getCours(): array
{
    global $pdo;
    creerTableCours();
    $stmt = $pdo->query("SELECT * FROM cours ORDER BY numero_cours");
    return $stmt->fetchAll();
}

function getUnCours(int $id): ?array
{
    global $pdo;
    creerTableCours();
    $stmt = $pdo->prepare("SELECT * FROM cours WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function ajouterCours(string $numero_cours, string $titre): void
{
    global $pdo;
    creerTableCours();
    $stmt = $pdo->prepare("INSERT INTO cours (numero_cours, titre) VALUES (?, ?)");
    $stmt->execute([$numero_cours, $titre]);
}

function modifierCours(int $id, string $numero_cours, string $titre): void
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE cours SET numero_cours = ?, titre = ? WHERE id = ?");
    $stmt->execute([$numero_cours, $titre, $id]);
}

function supprimerCours(int $id): void
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM cours WHERE id = ?");
    $stmt->execute([$id]);
}

function numeroCoursExiste(string $numero_cours, ?int $id_exclus = null): bool
{
    global $pdo;
    creerTableCours();
    
    if ($id_exclus === null) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM cours WHERE numero_cours = ?");
        $stmt->execute([$numero_cours]);
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM cours WHERE numero_cours = ? AND id != ?");
        $stmt->execute([$numero_cours, $id_exclus]);
    }
    
    return $stmt->fetchColumn() > 0;
}

function validerCours(?string $numero_cours, ?string $titre, ?int $id_exclus = null): array
{
    $erreurs = [];
    
    if ($numero_cours === null || trim($numero_cours) === '') {
        $erreurs[] = "Le numéro de cours est obligatoire.";
    } elseif (!preg_match('/^\d{3}-\d{3}$/', $numero_cours)) {
        $erreurs[] = "Le format du numéro doit être 999-999.";
    } elseif (numeroCoursExiste(trim($numero_cours), $id_exclus)) {
        $erreurs[] = "Ce numéro de cours existe déjà.";
    }
    
    if ($titre === null || trim($titre) === '') {
        $erreurs[] = "Le titre est obligatoire.";
    }
    
    return $erreurs;
}