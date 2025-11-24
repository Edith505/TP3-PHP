<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<h2>Inscriptions</h2>

<!-- Formulaire d'inscription -->
<form method="post" action="inscrire.php">
    <!-- todo : compléter le formulaire inscription -->
    <select id="etudiant" name="etudiant">
        <option selected>Etudiant</option>
        <option>Nom etudiant 1</option>
        <option>Nom etudiant 2</option>
        <option>Nom etudiant 3</option>
        <option>...</option>
    </select>
    <select id="cours" name="cours">
        <option selected>Cours</option>
        <option>Cours 1</option>
        <option>Cours 2</option>
        <option>Cours 3</option>
        <option>...</option>
    </select>
    <select id="session" name="session">
        <option selected>Automne</option>
        <option>Hiver</option>
        <option>Ete</option>
    </select>
    <input type="text" name="annee" id="annee" placeholder="Année">
    <input type="text" name="note" id="note" placeholder="Note">
    <input type="submit" value="Inscrire">
</form>

<hr>

<h3>Liste des inscriptions</h3>

<?php
// todo : récupérer à partir d'une requête sql dans une variable la liste des inscriptions
?>



    <!-- todo : affichez la liste des inscriptions dans un tableau-->
<table>
    <tr>
        <th>Etudiant</th>
        <th>Cours</th>
        <th>Session</th>
        <th>Année</th>
        <th>Note</th>
        <th>Actions</th>
    </tr>
    <tr>
        <td><!--On ajoute ici le Nom de l'etudiant--></td>
        <td><!--On ajoute ici le titre du cours --></td>
        <td><!--On ajoute ici la Session --></td>
        <td><!--On ajoute ici l'anné --></td>
        <td><!--On ajoute ici la note --></td>
        <td><!--Bouttons :  modifier | Supprimer --></td>
    </tr>
</table>

<?php include 'footer.php'; ?>
