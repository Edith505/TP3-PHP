<?php
session_start();
require_once __DIR__ . '/functions_cours.php';
include 'header.php';

$erreurs = $_SESSION['erreurs'] ?? [];
$old_data = $_SESSION['old_data'] ?? [];
unset($_SESSION['erreurs'], $_SESSION['old_data']);
?>

<div class="container my-4">
    <h2 class="mb-4">Cours</h2>

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

    <form method="post" action="ajouter_cours.php" class="row g-3 align-items-end mb-4">
        <div class="col-md-4">
            <label for="numero_cours" class="form-label visually-hidden">Numéro</label>
            <input type="text" id="numero_cours" name="numero_cours" 
                   placeholder="999-999" class="form-control" 
                   value="<?= htmlspecialchars($old_data['numero_cours'] ?? '') ?>" required>
        </div>
        <div class="col-md-6">
            <label for="titre" class="form-label visually-hidden">Titre</label>
            <input type="text" id="titre" name="titre" 
                   placeholder="Titre du cours" class="form-control" 
                   value="<?= htmlspecialchars($old_data['titre'] ?? '') ?>" required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
    </form>

    <?php
    $cours_list = getCours();
    ?>

    <?php if (empty($cours_list)): ?>
        <div class="alert alert-info">Aucun cours trouvé.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Numéro</th>
                        <th>Titre</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cours_list as $cours): ?>
                    <tr>
                        <td><?= htmlspecialchars($cours['numero_cours']) ?></td>
                        <td><?= htmlspecialchars($cours['titre']) ?></td>
                        <td class="text-end">
                            <a href="modifier_cours.php?id=<?= urlencode($cours['id']) ?>" class="btn btn-sm btn-outline-success me-2">Modifier</a>
                            <a href="supprimer_cours.php?id=<?= urlencode($cours['id']) ?>"
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