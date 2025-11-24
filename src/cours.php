<?php
require_once __DIR__ . '/functions_cours.php';
include 'header.php';
?>

    <h2>Cours</h2>

    <form method="post" action="ajouter_cours.php">
        <input type="text" id="numero_cours" name="numero_cours" placeholder="999-999">
        <input type="text" id="titre" name="titre" placeholder="Titre du cours">
        <input type="submit" value="Ajouter">
    </form>

<?php
$cours_list = getCours();
?>

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
                       onclick="return confirm('Êtes-vous sûr?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php include 'footer.php'; ?>