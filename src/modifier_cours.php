<?php include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE); //pour éviter les warning
ini_set('display_errors', 1);               //pour afficher les erreurs


// todo : récupérez le cours à modifier

?>

<h2>Modifier un cours</h2>

<form method="post">
    // todo :afficher le cours dans le formulaire
</form>

<?php
if ($_POST) {

    // todo : préparez la requête de mise à jour puis exécutez-la


    header("Location: cours.php");
}
?>

<?php include 'footer.php'; ?>
