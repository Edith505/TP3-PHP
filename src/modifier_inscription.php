<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE); //pour éviter les warning
ini_set('display_errors', 1);               //pour afficher les erreurs

// todo : récupérez l l'inscription à modifier

?>

<h2>Modifier inscription</h2>

<form method="post">
    <form method="post" action="">

        // todo :afficher l 'inscription dans le formulaire

    </form>
</form>

<?php
if ($_POST) {
    // todo : préparez la requête de mise à jour puis exécutez-la

    header("Location: inscriptions.php");
}
?>

<?php include 'footer.php'; ?>
