<?php
session_start();
require_once __DIR__ . '/functions_etudiant.php';
include 'header.php';

$erreurs = $_SESSION['erreurs'] ?? [];
$old_data = $_SESSION['old_data'] ?? [];
unset($_SESSION['erreurs'], $_SESSION['old_data']);
?>

<div class="container my-4">
    <h2 class="mb-4">Étudiants</h2>

    <?php if (!empty($erreurs)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'ajout -->
    <form method="post" action="ajouter_etudiant.php" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label for="nom" class="form-label visually-hidden">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" 
                   placeholder="Nom" value="<?= htmlspecialchars($old_data['nom'] ?? '') ?>">
        </div>
        <div class="col-md-4">
            <label for="courriel" class="form-label visually-hidden">Courriel</label>
            <input type="email" id="courriel" name="courriel" class="form-control" 
                   placeholder="Courriel" value="<?= htmlspecialchars($old_data['courriel'] ?? '') ?>" >
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
    </form>

    <?php $etudiants = getEtudiants(); ?>

    <!-- Affichage de la liste des étudiants -->
    <?php if (empty($etudiants)): ?>
        <div class="alert alert-info">Aucun étudiant trouvé.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Courriel</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                        <td><?= htmlspecialchars($etudiant['courriel']) ?></td>
                        <td class="text-end">
                            <a href="modifier_etudiant.php?id=<?= $etudiant['id'] ?>" class="btn btn-sm btn-outline-success me-2">Modifier</a>
                            <a href="supprimer_etudiant.php?id=<?= $etudiant['id'] ?>"
                               onclick="return confirm('Êtes-vous sûr?')" class="btn btn-sm btn-outline-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>