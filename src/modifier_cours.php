<?php global $pdo;
include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', 1);

// Récupérer le cours à modifier
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    header("Location: cours.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_cours = trim($_POST['numero_cours']);
    $titre = trim($_POST['titre']); // Nom du champ dans ce formulaire

    if (!empty($numero_cours) && !empty($titre)) {
        try {
            $stmt = $pdo->prepare("UPDATE cours SET numero_cours = :numero_cours, titre = :titre WHERE id = :id");
            $stmt->execute([
                ':numero_cours' => $numero_cours,
                ':titre' => $titre,
                ':id' => $id
            ]);
            // Redirection après succès (PRG)
            header("Location: cours.php");
            exit;
        } catch (PDOException $e) {
            // Gérer les erreurs (e.g. numéro de cours déjà utilisé)
            $erreur = "Erreur lors de la mise à jour: Le numéro de cours est peut-être déjà utilisé.";
        }
    } else {
        $erreur = "Tous les champs sont requis.";
    }
}

$stmt = $pdo->prepare("SELECT * FROM cours WHERE id = :id");
$stmt->execute([':id' => $id]);
$cours = $stmt->fetch();

if (!$cours) {
    header("Location: cours.php");
    exit;
}
?>

    <h2>Modifier un cours</h2>
<?php if (isset($erreur)): ?>
    <p style="color: red;"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>
    <form method="post">
        <input type="text" name="numero_cours" value="<?= htmlspecialchars($cours['numero_cours']) ?>"
               placeholder="999-999" pattern="\d{3}-\d{3}" required>
        <input type="text" name="titre" value="<?= htmlspecialchars($cours['titre']) ?>"
               placeholder="Titre" required>
        <input type="submit" value="Modifier">
        <a href="cours.php">Annuler</a>
    </form>

<?php
if ($_POST) {
    $numero_cours = trim($_POST['numero_cours']);
    $titre = trim($_POST['titre']);

    if (!empty($numero_cours) && !empty($titre)) {
        $stmt = $pdo->prepare("UPDATE cours SET numero_cours = :numero_cours, titre = :titre WHERE id = :id");
        $stmt->execute([
            ':numero_cours' => $numero_cours,
            ':titre' => $titre,
            ':id' => $id
        ]);
    }

    header("Location: cours.php");
    exit;
}
?>

<?php include 'footer.php'; ?>