<?php
require_once __DIR__ . '/functions_etudiant.php';
include 'header.php';
?>

<div class="container my-4">
    <h2 class="mb-4">Étudiants</h2>

    <!-- Formulaire d'ajout (Bootstrap uniquement) -->
    <form method="post" action="ajouter_etudiant.php" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label for="nom" class="form-label visually-hidden">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" placeholder="Nom" required>
        </div>
        <div class="col-md-4">
            <label for="courriel" class="form-label visually-hidden">Courriel</label>
            <input type="email" id="courriel" name="courriel" class="form-control" placeholder="Courriel" required>
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