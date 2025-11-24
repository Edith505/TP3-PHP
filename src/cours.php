<?php global $pdo;
include 'header.php'; ?>
<?php require 'db.php'; ?>

    <h2>Cours</h2>

    <form method="post" action="ajouter_cours.php">
        <input type="text" id="cours" name="cours" placeholder="999-999" pattern="\d{3}-\d{3}" required>
        <input type="text" id="titre_cours" name="titre_cours" placeholder="Titre du cours" required>
        <input type="submit" value="Ajouter">
    </form>

<?php
// Récupérer la liste des cours
$stmt = $pdo->query("SELECT * FROM cours ORDER BY numero_cours");
$cours_list = $stmt->fetchAll();
?>

    <!-- Affichage de la liste des cours -->
    <table>
        <tr>
            <th>Numéro</th>
            <th>Titre</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($cours_list as $cours): ?>
            <tr>
                <td><?= htmlspecialchars($cours['numero_cours']) ?></td>
                <td><?= htmlspecialchars($cours['titre']) ?></td>
                <td>
                    <a href="modifier_cours.php?id=<?= $cours['id'] ?>">Modifier</a> |
                    <a href="supprimer_cours.php?id=<?= $cours['id'] ?>"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours? (Les inscriptions seront aussi supprimées)')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php include 'footer.php'; ?>