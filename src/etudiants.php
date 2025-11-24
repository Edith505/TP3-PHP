<?php
require_once __DIR__ . '/functions_etudiant.php';
include 'header.php';
?>

<h2>Étudiants</h2>

<!-- Formulaire d'ajout -->
<form method="post" action="ajouter_etudiant.php">
    <input type="text" id="nom" name="nom" placeholder="Nom">
    <input type="email" id="courriel" name="courriel" placeholder="Courriel">
    <input type="submit" value="Ajouter">
</form>

<?php $etudiants = getEtudiants(); ?>

<!-- Affichage de la liste des étudiants -->
<table>
    <tr>
        <th>Nom</th>
        <th>Courriel</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($etudiants as $etudiant): ?>
        <tr>
            <td><?= htmlspecialchars($etudiant['nom']) ?></td>
            <td><?= htmlspecialchars($etudiant['courriel']) ?></td>
            <td>
                <a href="modifier_etudiant.php?id=<?= $etudiant['id'] ?>">Modifier</a> |
                <a href="supprimer_etudiant.php?id=<?= $etudiant['id'] ?>"
                   onclick="return confirm('Êtes-vous sûr?')">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
