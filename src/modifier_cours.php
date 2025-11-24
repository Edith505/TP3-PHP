<?php
require_once __DIR__ . '/functions_cours.php';
include 'header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: cours.php");
    exit;
}

$cours = getUnCours((int)$id);
if (!$cours) {
    header("Location: cours.php");
    exit;
}

$erreurs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_cours = $_POST['numero_cours'] ?? null;
    $titre = $_POST['titre'] ?? null;

    $erreurs = validerCours($numero_cours, $titre);

    if (empty($erreurs)) {
        modifierCours((int)$id, trim($numero_cours), trim($titre));
        header("Location: cours.php");
        exit;
    }
}
?>

    <h2>Modifier un cours</h2>

<?php if (!empty($erreurs)): ?>
    <div class="error">
        <?php foreach ($erreurs as $erreur): ?>
            <p><?= htmlspecialchars($erreur) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

    <form method="post">
        <input type="text" name="numero_cours" value="<?= htmlspecialchars($cours['numero_cours']) ?>"
               placeholder="999-999" pattern="\d{3}-\d{3}" required>
        <input type="text" name="titre" value="<?= htmlspecialchars($cours['titre']) ?>"
               placeholder="Titre" required>
        <input type="submit" value="Modifier">
        <a href="cours.php">Annuler</a>
    </form>

<?php include 'footer.php'; ?>