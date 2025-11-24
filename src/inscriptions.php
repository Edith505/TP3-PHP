<?php
require_once __DIR__ . '/functions_inscription.php';
require_once __DIR__ . '/functions_etudiant.php';
require_once __DIR__ . '/functions_cours.php';
include 'header.php';
?>

<h2>Inscriptions</h2>

<form method="post" action="inscrire.php">
    <select id="etudiant" name="etudiant">
        <option value="">Etudiant</option>
        <?php
        $etudiants = getEtudiants();
        foreach ($etudiants as $etudiant) {
            echo "<option value='{$etudiant['id']}'>" . htmlspecialchars($etudiant['nom']) . "</option>";
        }
        ?>
    </select>

    <select id="cours" name="cours">
        <option value="">Sélectionner un cours</option>
        <?php
        $cours_list = getCours();
        foreach ($cours_list as $cours) {
            echo "<option value='{$cours['id']}'>" .
                htmlspecialchars($cours['numero_cours'] . ' - ' . $cours['titre']) .
                "</option>";
        }
        ?>
    </select>

    <select id="session" name="session">
        <option value="AUT">Automne</option>
        <option value="HIV">Hiver</option>
        <option value="ETE">Été</option>
    </select>

    <input type="number" name="annee" id="annee" placeholder="Année">
    <input type="number" name="note" id="note" placeholder="Note">
    <input type="submit" value="Inscrire">
</form>

<hr>

<h3>Liste des inscriptions</h3>

<?php
$inscriptions = getInscriptions();
?>

<table>
    <tr>
        <th>Étudiant</th>
        <th>Cours</th>
        <th>Session</th>
        <th>Année</th>
        <th>Note</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($inscriptions as $inscription): ?>
        <tr>
            <td><?= htmlspecialchars($inscription['nom_etudiant']) ?></td>
            <td><?= htmlspecialchars($inscription['numero_cours'] . ' - ' . $inscription['titre_cours']) ?></td>
            <td><?= htmlspecialchars($inscription['session']) ?></td>
            <td><?= htmlspecialchars($inscription['annee']) ?></td>
            <td><?= $inscription['note'] !== null ? number_format($inscription['note'], 2) : 'N/A' ?></td>
            <td>
                <a href="modifier_inscription.php?id_etudiant=<?= $inscription['id_etudiant'] ?>&id_cours=<?= $inscription['id_cours'] ?>">Modifier</a>
                |
                <a href="desinscrire.php?id_etudiant=<?= $inscription['id_etudiant'] ?>&id_cours=<?= $inscription['id_cours'] ?>"
                   onclick="return confirm('Êtes-vous sûr?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
