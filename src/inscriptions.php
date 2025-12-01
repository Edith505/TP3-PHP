<?php
session_start();
require_once __DIR__ . '/functions_inscription.php';
require_once __DIR__ . '/functions_etudiant.php';
require_once __DIR__ . '/functions_cours.php';
include 'header.php';

$erreurs = $_SESSION['erreurs'] ?? [];
$old_data = $_SESSION['old_data'] ?? [];
unset($_SESSION['erreurs'], $_SESSION['old_data']);
?>

<div class="container my-4">
    <h2 class="mb-4">Inscriptions</h2>

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

    <form method="post" action="inscrire.php" class="row g-3 align-items-end mb-4">
        <div class="col-md-2">
            <label for="etudiant" class="form-label visually-hidden">Étudiant</label>
            <select id="etudiant" name="etudiant" class="form-select">
                <option value="">Étudiant</option>
                <?php
                $etudiants = getEtudiants();
                foreach ($etudiants as $etudiant) {
                    $selected = isset($old_data['etudiant']) && $old_data['etudiant'] == $etudiant['id'] ? 'selected' : '';
                    echo "<option value=\"" . htmlspecialchars($etudiant['id']) . "\" $selected>" . htmlspecialchars($etudiant['nom']) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-2">
            <label for="cours" class="form-label visually-hidden">Cours</label>
            <select id="cours" name="cours" class="form-select">
                <option value="">Sélectionner un cours</option>
                <?php
                $cours_list = getCours();
                foreach ($cours_list as $cours) {
                    $label = $cours['numero_cours'] . ' - ' . $cours['titre'];
                    $selected = isset($old_data['cours']) && $old_data['cours'] == $cours['id'] ? 'selected' : '';
                    echo "<option value=\"" . htmlspecialchars($cours['id']) . "\" $selected>" . htmlspecialchars($label) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-2">
            <label for="session" class="form-label visually-hidden">Session</label>
            <select id="session" name="session" class="form-select">
                <option value="AUT" <?= isset($old_data['session']) && $old_data['session'] == 'AUT' ? 'selected' : '' ?>>Automne</option>
                <option value="HIV" <?= isset($old_data['session']) && $old_data['session'] == 'HIV' ? 'selected' : '' ?>>Hiver</option>
                <option value="ETE" <?= isset($old_data['session']) && $old_data['session'] == 'ETE' ? 'selected' : '' ?>>Été</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="annee" class="form-label visually-hidden">Année</label>
            <input type="number" name="annee" id="annee" class="form-control" 
                   placeholder="Année" value="<?= htmlspecialchars($old_data['annee'] ?? '') ?>">
        </div>

        <div class="col-md-2">
            <label for="note" class="form-label visually-hidden">Note</label>
            <input type="text" name="note" id="note" class="form-control" 
                   placeholder="Note" pattern="\d+\.\d{2}" 
                   value="<?= htmlspecialchars($old_data['note'] ?? '') ?>">
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Inscrire</button>
        </div>
    </form>

    <hr>

    <h3 class="mt-4">Liste des inscriptions</h3>

    <?php
    $inscriptions = getInscriptions();
    ?>

    <?php if (empty($inscriptions)): ?>
        <div class="alert alert-info">Aucune inscription trouvée.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Étudiant</th>
                        <th>Cours</th>
                        <th>Session</th>
                        <th>Année</th>
                        <th>Note</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($inscriptions as $inscription): ?>
                    <tr>
                        <td><?= htmlspecialchars($inscription['nom_etudiant']) ?></td>
                        <td><?= htmlspecialchars($inscription['numero_cours'] . ' - ' . $inscription['titre_cours']) ?></td>
                        <td><?= htmlspecialchars($inscription['session']) ?></td>
                        <td><?= htmlspecialchars($inscription['annee']) ?></td>
                        <td><?= $inscription['note'] !== null ? number_format($inscription['note'], 2, '.', '') . ' %' : 'N/A' ?></td>
                        <td class="text-end">
                            <a href="modifier_inscription.php?id_etudiant=<?= urlencode($inscription['id_etudiant']) ?>&id_cours=<?= urlencode($inscription['id_cours']) ?>"
                               class="btn btn-sm btn-outline-success me-2">Modifier</a>
                            <a href="desinscrire.php?id_etudiant=<?= urlencode($inscription['id_etudiant']) ?>&id_cours=<?= urlencode($inscription['id_cours']) ?>"
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