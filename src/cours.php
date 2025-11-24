<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<h2>Cours</h2>

<form method="post" action="ajouter_cours.php">


        <!-- todo : compléter le formulaire Cours-->
    <input type="text" id="cours" name="cours" placeholder="999-999">
    <input type="text" id="titre_cours" name="titre_cours" placeholder="Nom">
    <input type="submit" value="Ajouter">

</form>

    <?php
    // todo : récupérer à partir d'une requête sql dans une variable la liste des Cours

    ?>

    <!-- todo : affichez la liste des cours dans un tableau-->
<table>
    <tr>
        <th>Numéro</th>
        <th>Titre</th>
        <th>Actions</th>
    </tr>
    <tr>
        <td><!--On ajoute ici le Numéro du cours--></td>
        <td><!--On ajoute ici le titre du cours --></td>
        <td><!--Bouttons :  modifier | Supprimer --></td>
    </tr>
</table>

    <?php include 'footer.php'; ?>
