
<?php include 'header.php'; ?>
<?php require 'db.php'; ?>
<?php global$pdo; ?>
<h2>Inscriptions</h2>

<form method="post" action="inscrire.php">
    <select id="etudiant" name="etudiant" required>
        <option value="">Sélectionner un étudiant</option>
        <?php
        $etudiants = $pdo->query("SELECT * FROM etudiant ORDER BY nom")->fetchAll();
        foreach ($etudiants as $etudiant) {
            echo "<option value='{$etudiant['id']}'>" . htmlspecialchars($etudiant['nom']) . "</option>";
        }
        ?>
    </select>

    <select id="cours" name="cours" required>
        <option value="">Sélectionner un cours</option>
        <?php
        $cours_list = $pdo->query("SELECT * FROM cours ORDER BY numero_cours")->fetchAll();
        foreach ($cours_list as $cours) {
            echo "<option value='{$cours['id']}'>" . htmlspecialchars($cours['numero_cours'] . ' - ' . $cours['titre']) . "</option>";
        }
        ?>
    </select>

    <select id="session" name="session" required>
        <option value="AUT">Automne</option>
        <option value="HIV">Hiver</option>
        <option value="ETE">Été</option>
    </select>

    <input type="number" name="annee" id="annee" placeholder="Année" min="2000" max="2100" required>
    <input type="number" name="note" id="note" placeholder="Note">
    <input type="submit" value="Inscrire">
</form>

<hr>

<h3>Liste des inscriptions</h3>

<?php
// Récupérer la liste des inscriptions avec jointures
$stmt = $pdo->query("
    SELECT 
        i.id_etudiant,
        i.id_cours,
        i.session,
        i.annee,
        e.nom as nom_etudiant,
        c.numero_cours,
        c.titre as titre_cours,
        i.note
    FROM inscription i
    JOIN etudiant e ON i.id_etudiant = e.id
    JOIN cours c ON i.id_cours = c.id
    ORDER BY i.annee DESC, i.session, e.nom
");
$inscriptions = $stmt->fetchAll();
?>

<table>
    <tr>
        <th>Etudiant</th>
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
                <a href="modifier_inscription.php?id_etudiant=<?= $inscription['id_etudiant'] ?>&id_cours=<?= $inscription['id_cours'] ?>&session=<?= $inscription['session'] ?>&annee=<?= $inscription['annee'] ?>">Modifier</a> |
                <a href="desinscrire.php?id_etudiant=<?= $inscription['id_etudiant'] ?>&id_cours=<?= $inscription['id_cours'] ?>&session=<?= $inscription['session'] ?>&annee=<?= $inscription['annee'] ?>"
                   onclick="return confirm('Êtes-vous sûr?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>