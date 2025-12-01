<?php
session_start();
require_once __DIR__ . '/functions_inscription.php';

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
        $_SESSION['success'] = "Inscription modifiée avec succès.";
        header("Location: inscriptions.php");
        exit;
    }
    $inscription['session'] = $session;
    $inscription['annee'] = $annee;
    $inscription['note'] = $noteStr;
}

include 'header.php';
?>

<div class="container my-4">
    <h2 class="mb-4">Modifier inscription</h2>

    <?php if (!empty($erreurs)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erreur(s) :</strong>
            <ul class="mb-0">
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <p class="mb-1"><strong>Étudiant:</strong> <?= htmlspecialchars($inscription['nom_etudiant']) ?></p>
            <p class="mb-0"><strong>Cours:</strong> <?= htmlspecialchars($inscription['numero_cours'] . ' - ' . $inscription['titre_cours']) ?></p>
        </div>
    </div>

    <form method="post" class="row g-3">
        <div class="col-md-4">
            <label for="session" class="form-label">Session</label>
            <select id="session" name="session" class="form-select" required>
                <option value="AUT" <?= $inscription['session'] == 'AUT' ? 'selected' : '' ?>>Automne</option>
                <option value="HIV" <?= $inscription['session'] == 'HIV' ? 'selected' : '' ?>>Hiver</option>
                <option value="ETE" <?= $inscription['session'] == 'ETE' ? 'selected' : '' ?>>Été</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="annee" class="form-label">Année</label>
            <input type="number" id="annee" name="annee" 
                   value="<?= htmlspecialchars($inscription['annee']) ?>"
                   placeholder="Année" class="form-control" required>
        </div>

        <div class="col-md-4">
            <label for="note" class="form-label">Note (optionnelle)</label>
            <input type="text" id="note" name="note" 
                   value="<?= isset($inscription['note']) && $inscription['note'] !== '' && $inscription['note'] !== null ? (is_numeric($inscription['note']) ? number_format((float)$inscription['note'], 2, '.', '') : htmlspecialchars($inscription['note'])) : '' ?>"
                   placeholder="Note (ex: 80.00)" class="form-control">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Modifier</button>
            <a href="inscriptions.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>