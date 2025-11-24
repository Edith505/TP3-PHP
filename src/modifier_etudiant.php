<?php
require_once __DIR__ . '/functions_etudiant.php';
include 'header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: etudiants.php");
    exit;
}

$etudiant = getEtudiant((int)$id);
if (!$etudiant) {
    header("Location: etudiants.php");
    exit;
}

$erreurs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? null;
    $courriel = $_POST['courriel'] ?? null;

    $erreurs = validerEtudiant($nom, $courriel);

    if (empty($erreurs)) {
        modifierEtudiant((int)$id, trim($nom), trim($courriel));
        header("Location: etudiants.php");
        exit;
    }
}
?>

    <h2>Modifier étudiant</h2>

<?php if (!empty($erreurs)): ?>
    <div class="error">
        <?php foreach ($erreurs as $erreur): ?>
            <p><?= htmlspecialchars($erreur) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

    <form method="post">
        <input type="text" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>"
               placeholder="Nom" required>
        <input type="email" name="courriel" value="<?= htmlspecialchars($etudiant['courriel']) ?>"
               placeholder="Courriel" required>
        <input type="submit" value="Modifier">
        <a href="etudiants.php">Annuler</a>
    </form>

<?php include 'footer.php'; ?>