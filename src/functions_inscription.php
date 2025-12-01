<?php
require_once __DIR__ . '/db.php';

function creerTableInscriptions(): void
{
    global $pdo;
    $sql = "
    CREATE TABLE IF NOT EXISTS inscription (
        id_etudiant INT,
        id_cours INT,
        session ENUM('AUT','HIV','ETE') NOT NULL,
        annee INT NOT NULL,
        note VARCHAR(5) DEFAULT NULL,
        PRIMARY KEY (id_etudiant, id_cours),
        FOREIGN KEY (id_etudiant) REFERENCES etudiant(id) ON DELETE CASCADE,
        FOREIGN KEY (id_cours) REFERENCES cours(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ";
    $pdo->exec($sql);
}

function getInscriptions(): array
{
    global $pdo;
    creerTableInscriptions();
    $stmt = $pdo->query("
        SELECT 
            i.id_etudiant,
            i.id_cours,
            e.nom as nom_etudiant,
            c.numero_cours,
            c.titre as titre_cours,
            i.session,
            i.annee,
            i.note
        FROM inscription i
        JOIN etudiant e ON i.id_etudiant = e.id
        JOIN cours c ON i.id_cours = c.id
        ORDER BY i.annee DESC, i.session, e.nom
    ");
    return $stmt->fetchAll();
}

function getInscription(int $id_etudiant, int $id_cours): ?array
{
    global $pdo;
    creerTableInscriptions();
    $stmt = $pdo->prepare("
        SELECT 
            i.*,
            e.nom as nom_etudiant,
            c.numero_cours,
            c.titre as titre_cours
        FROM inscription i
        JOIN etudiant e ON i.id_etudiant = e.id
        JOIN cours c ON i.id_cours = c.id
        WHERE i.id_etudiant = ? AND i.id_cours = ?
    ");
    $stmt->execute([$id_etudiant, $id_cours]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function ajouterInscription(int $id_etudiant, int $id_cours, string $session, int $annee, ?float $note): void
{
    global $pdo;
    creerTableInscriptions();
    $stmt = $pdo->prepare("
        INSERT INTO inscription (id_etudiant, id_cours, session, annee, note) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$id_etudiant, $id_cours, $session, $annee, $note]);
}

function modifierInscription(int $id_etudiant, int $id_cours, string $session, int $annee, ?float $note): void
{
    global $pdo;
    $stmt = $pdo->prepare("
        UPDATE inscription 
        SET session = ?, annee = ?, note = ? 
        WHERE id_etudiant = ? AND id_cours = ?
    ");
    $stmt->execute([$session, $annee, $note, $id_etudiant, $id_cours]);
}

function supprimerInscription(int $id_etudiant, int $id_cours): void
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM inscription WHERE id_etudiant = ? AND id_cours = ?");
    $stmt->execute([$id_etudiant, $id_cours]);
}

function validerInscription(?string $id_etudiant, ?string $id_cours, ?string $session, ?string $annee, ?string $noteStr): array
{
    $erreurs = [];

    if ($id_etudiant === null || $id_etudiant === '') {
        $erreurs[] = "L'étudiant est obligatoire.";
    }
    if ($id_cours === null || $id_cours === '') {
        $erreurs[] = "Le cours est obligatoire.";
    }
    if ($session === null || $session === '') {
        $erreurs[] = "La session est obligatoire.";
    }
    if ($annee === null || $annee === '') {
        $erreurs[] = "L'année est obligatoire.";
    }

    $note = null;
    if ($noteStr !== null && $noteStr !== '') {
            $note = (float)$noteStr;
            if ($note < 0 || $note > 100) {
                $erreurs[] = "La note doit être entre 0 et 100.";
            }
    }

    return [$erreurs, $note];
}