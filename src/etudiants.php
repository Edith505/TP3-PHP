<?php global $pdo;
include 'header.php'; ?>
<?php require 'db.php'; ?>

    <h2>Étudiants</h2>

    <!-- Formulaire d'ajout -->
    <form method="post" action="ajouter_etudiant.php">
        <input type="text" id="nom" name="nom" placeholder="Nom" required>
        <input type="email" id="courriel" name="courriel" placeholder="Courriel" required>
        <input type="submit" value="Ajouter">
    </form>

<?php
// Récupérer la liste des étudiants
$stmt = $pdo->query("SELECT * FROM etudiant ORDER BY nom");
$etudiants = $stmt->fetchAll();
?>

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
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant? (Les inscriptions seront aussi supprimées)')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php include 'footer.php'; ?>