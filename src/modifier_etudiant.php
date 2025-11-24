<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE); //pour éviter les warning
ini_set('display_errors', 1);               //pour afficher les erreurs

// todo : récupérez l etudiant à modifier
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: etudiants.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM etudiant WHERE id = :id");
$stmt->execute([':id' => $id]);
$etudiant = $stmt->fetch();

if (!$etudiant) {
    header("Location: etudiants.php");
    exit;
}
?>

<h2>Modifier étudiant</h2>

<form method="post" action="">
    <input type="text" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>"
           placeholder="Nom" required>
    <input type="email" name="courriel" value="<?= htmlspecialchars($etudiant['courriel']) ?>"
           placeholder="Courriel" required>
    <input type="submit" value="Modifier">
    <a href="etudiants.php">Annuler</a>
</form>

<?php
if ($_POST) {

    // todo : préparez la requête de mise à jour puis exécutez-la
    $nom = trim($_POST['nom']);
    $courriel = trim($_POST['courriel']);

    if (!empty($nom) && !empty($courriel)) {
        $stmt = $pdo->prepare("UPDATE etudiant SET nom = :nom, courriel = :courriel WHERE id = :id");
        $stmt->execute([
            ':nom' => $nom,
            ':courriel' => $courriel,
            ':id' => $id
        ]);
    }
    header("Location: etudiants.php");
}
?>

<?php include 'footer.php'; ?>
