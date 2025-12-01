<?php
session_start();
require_once __DIR__ . '/functions_etudiant.php';

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
        $_SESSION['success'] = "Étudiant modifié avec succès.";
        header("Location: etudiants.php");
        exit;
    }
    // Si erreurs, on garde les valeurs saisies
    $etudiant['nom'] = $nom;
    $etudiant['courriel'] = $courriel;
}

include 'header.php';
?>

<div class="container my-4">
    <h2 class="mb-4">Modifier étudiant</h2>

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

    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" 
                   value="<?= htmlspecialchars($etudiant['nom']) ?>"
                   placeholder="Nom" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="courriel" class="form-label">Courriel</label>
            <input type="email" id="courriel" name="courriel" 
                   value="<?= htmlspecialchars($etudiant['courriel']) ?>"
                   placeholder="Courriel" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Modifier</button>
            <a href="etudiants.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>