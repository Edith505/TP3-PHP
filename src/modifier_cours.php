<?php
session_start();
require_once __DIR__ . '/functions_cours.php';

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
        $_SESSION['success'] = "Cours modifié avec succès.";
        header("Location: cours.php");
        exit;
    }
    // Si erreurs, on garde les valeurs saisies
    $cours['numero_cours'] = $numero_cours;
    $cours['titre'] = $titre;
}

include 'header.php';
?>

<div class="container my-4">
    <h2 class="mb-4">Modifier un cours</h2>

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
        <div class="col-md-4">
            <label for="numero_cours" class="form-label">Numéro</label>
            <input type="text" id="numero_cours" name="numero_cours" 
                   value="<?= htmlspecialchars($cours['numero_cours']) ?>"
                   placeholder="999-999" class="form-control" required>
        </div>
        <div class="col-md-8">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" id="titre" name="titre" 
                   value="<?= htmlspecialchars($cours['titre']) ?>"
                   placeholder="Titre" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Modifier</button>
            <a href="cours.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>