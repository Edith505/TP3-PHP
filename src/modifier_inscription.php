<?php
require_once __DIR__ . '/functions_inscription.php';
include 'header.php';

$id_etudiant = $_GET['id_etudiant'] ?? null;
$id_cours = $_GET['id_cours'] ?? null;

if (!$id_etudiant || !$id_cours) {
    header("Location: inscriptions.php");
    exit;
}

$inscription = getInscription((int)$id_etudiant, (int)$id_cours);
if (!$inscription) {
    header("Location: inscriptions.php");
    exit;
}

$erreurs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session = $_POST['session'] ?? null;
    $annee = $_POST['annee'] ?? null;
    $noteStr = $_POST['note'] ?? null;

    [$erreurs, $note] = validerInscription($id_etudiant, $id_cours, $session, $annee, $noteStr);

    if (empty($erreurs)) {
        modifierInscription((int)$id_etudiant, (int)$id_cours, $session, (int)$annee, $note);
        header("Location: inscriptions.php");
        exit;
    }
}
?>

<h2>Modifier inscription</h2>

<?php if (!empty($erreurs)): ?>
    <div class="error">
        <?php foreach ($erreurs as $erreur): ?>
            <p><?= htmlspecialchars($erreur) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<p><strong>Étudiant:</strong> <?= htmlspecialchars($inscription['nom_etudiant']) ?></p>
<p><strong>Cours:</strong> <?= htmlspecialchars($inscription['numero_cours'] . ' - ' . $inscription['titre_cours']) ?></p>

<form method="post">
    <select name="session">
        <option value="AUT" <?= $inscription['session'] == 'AUT' ? 'selected' : '' ?>>Automne</option>
        <option value="HIV" <?= $inscription['session'] == 'HIV' ? 'selected' : '' ?>>Hiver</option>
        <option value="ETE" <?= $inscription['session'] == 'ETE' ? 'selected' : '' ?>>Été</option>
    </select>

    <input type="number" name="annee" value="<?= htmlspecialchars($inscription['annee']) ?>"
           placeholder="Année">

    <input type="number" name="note" value="<?= htmlspecialchars($inscription['note']) ?>"
           placeholder="Note">

    <input type="submit" value="Modifier">
    <a href="inscriptions.php">Annuler</a>
</form>

<?php include 'footer.php'; ?>
