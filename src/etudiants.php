<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<h2>Étudiants</h2>

<!-- Formulaire d'ajout -->
<form method="post" action="ajouter_etudiant.php">
    <!-- todo : compléter le formulaire Étudiants-->
    <input type="text" id="nom" name="nom" placeholder="Nom">
    <input type="email" id="courriel" name="courriel" placeholder="Nom">
    <input type="submit" value="Ajouter">
</form>

<?php
// todo : récupérer à partir d'une requête sql dans une variable la liste des étudiants

?>

<!-- todo : affichez la liste des étudiants dans un tableau-->
<table>
    <tr>
        <th>Nom</th>
        <th>Courriel</th>
        <th>Actions</th>
    </tr>
    <tr>
        <td><!--On ajoute ici le nom--></td>
        <td><!--On ajoute ici le --></td>
        <td><!--Bouttons :  modifier | Supprimer --></td>
    </tr>
</table>



<?php include 'footer.php'; ?>
