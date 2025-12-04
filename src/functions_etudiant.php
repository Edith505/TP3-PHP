<?php
require_once __DIR__ . '/db.php';

function creerTableEtudiants(): void
{
    global $pdo;
    $sql = "
    CREATE TABLE IF NOT EXISTS etudiant (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(150) NOT NULL,
        courriel VARCHAR(150) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ";
    $pdo->exec($sql);
}

function getEtudiants(): array
{
    global $pdo;
    creerTableEtudiants();
    $stmt = $pdo->query("SELECT * FROM etudiant ORDER BY nom");
    return $stmt->fetchAll();
}

function getEtudiant(int $id): ?array
{
    global $pdo;
    creerTableEtudiants();
    $stmt = $pdo->prepare("SELECT * FROM etudiant WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function ajouterEtudiant(string $nom, string $courriel): void
{
    global $pdo;
    creerTableEtudiants();
    $stmt = $pdo->prepare("INSERT INTO etudiant (nom, courriel) VALUES (?, ?)");
    $stmt->execute([$nom, $courriel]);
}

function modifierEtudiant(int $id, string $nom, string $courriel): void
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE etudiant SET nom = ?, courriel = ? WHERE id = ?");
    $stmt->execute([$nom, $courriel, $id]);
}

function supprimerEtudiant(int $id): void
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM etudiant WHERE id = ?");
    $stmt->execute([$id]);
}

function validerEtudiant(?string $nom, ?string $courriel): array
{
    $erreurs = [];
    
    // Validation du nom
    if ($nom === null || trim($nom) === '') {
        $erreurs[] = "Le nom est obligatoire.";
    } elseif (strlen(trim($nom)) < 3) {
        $erreurs[] = "Le nom doit contenir au moins 3 caractères.";
    } elseif (preg_match('/\d/', $nom)) {
        $erreurs[] = "Le nom ne doit pas contenir de chiffres.";
    }
    
    // Validation du courriel
    if ($courriel === null || trim($courriel) === '') {
        $erreurs[] = "Le courriel est obligatoire.";
    } elseif (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $courriel)) {
        $erreurs[] = "Le courriel doit être dans le format nom@domaine.com";
    }
    
    return $erreurs;
}
