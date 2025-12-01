<?php
require_once __DIR__ . '/functions_inscription.php';
require_once __DIR__ . '/functions_etudiant.php';
require_once __DIR__ . '/functions_cours.php';
include 'header.php';
?>

<div class="mb-4">
    <h2>Inscriptions</h2>

    <form method="post" action="inscrire.php" class="row g-3 align-items-end">
        <div class="col-md-2">
            <label for="etudiant" class="form-label visually-hidden">Étudiant</label>
            <select id="etudiant" name="etudiant" class="form-select">
                <option value="">Étudiant</option>
                <?php
                $etudiants = getEtudiants();
                foreach ($etudiants as $etudiant) {
                    echo "<option value=\"" . htmlspecialchars($etudiant['id']) . "\">" . htmlspecialchars($etudiant['nom']) . "</option>";
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
                    echo "<option value=\"" . htmlspecialchars($cours['id']) . "\">" . htmlspecialchars($label) . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-2">
            <label for="session" class="form-label visually-hidden">Session</label>
            <select id="session" name="session" class="form-select">
                <option value="AUT">Automne</option>
                <option value="HIV">Hiver</option>
                <option value="ETE">Été</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="annee" class="form-label visually-hidden">Année</label>
            <input type="number" name="annee" id="annee" class="form-control" placeholder="Année">
        </div>

        <div class="col-md-2">
            <label for="note" class="form-label visually-hidden">Note</label>
            <input type="text" name="note" id="note" class="form-control" placeholder="Note">
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Inscrire</button>
        </div>
    </form>
</div>

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

<?php include 'footer.php'; ?>