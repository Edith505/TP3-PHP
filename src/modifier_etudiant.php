<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE); //pour éviter les warning
ini_set('display_errors', 1);               //pour afficher les erreurs

// todo : récupérez l etudiant à modifier
?>

<h2>Modifier étudiant</h2>

<form method="post" action="">
    // todo :afficher l etudiant dans le formulaire
</form>

<?php
if ($_POST) {

    // todo : préparez la requête de mise à jour puis exécutez-la

    header("Location: etudiants.php");
}
?>

<?php include 'footer.php'; ?>
