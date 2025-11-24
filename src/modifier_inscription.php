<?php global $pdo;
include 'header.php'; ?>
<?php require 'db.php'; ?>

<?php
// Récupérer les identifiants de la clé primaire composite
$id_etudiant = isset($_GET['id_etudiant']) ? $_GET['id_etudiant'] : null;
$id_cours = isset($_GET['id_cours']) ? $_GET['id_cours'] : null;
$session_orig = isset($_GET['session']) ? $_GET['session'] : null;
$annee_orig = isset($_GET['annee']) ? $_GET['annee'] : null;

if (!$id_etudiant || !$id_cours || !$session_orig || !$annee_orig) {
    header("Location: inscriptions.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session = isset($_POST['session']) ? $_POST['session'] : null;
    $annee = isset($_POST['annee']) ? $_POST['annee'] : null;
    $note = !empty($_POST['note']) ? (float)$_POST['note'] : null;

    if ($session && $annee) {
        try {
            $stmt = $pdo->prepare("
                UPDATE inscription 
                SET session = :session, annee = :annee, note = :note 
                WHERE id_etudiant = :id_etudiant 
                AND id_cours = :id_cours
                AND session = :session_orig
                AND annee = :annee_orig
            ");
            $stmt->execute([
                ':session' => $session,
                ':annee' => $annee,
                ':note' => $note,
                ':id_etudiant' => $id_etudiant,
                ':id_cours' => $id_cours,
                ':session_orig' => $session_orig,
                ':annee_orig' => $annee_orig
            ]);
            // Redirection après succès (PRG)
            header("Location: inscriptions.php");
            exit;
        } catch (PDOException $e) {
            $erreur = "Erreur lors de la mise à jour: L'inscription existe peut-être déjà avec la nouvelle session/année.";
        }
    } else {
        $erreur = "La session et l'année sont requises.";
    }
}

// 2. Récupérer l'inscription à modifier
$stmt = $pdo->prepare("
    SELECT 
        i.*,
        e.nom as nom_etudiant,
        c.numero_cours,
        c.titre as titre_cours
    FROM inscription i
    JOIN etudiant e ON i.id_etudiant = e.id
    JOIN cours c ON i.id_cours = c.id
    WHERE i.id_etudiant = :id_etudiant 
    AND i.id_cours = :id_cours
    AND i.session = :session_orig
    AND i.annee = :annee_orig
");
$stmt->execute([
    ':id_etudiant' => $id_etudiant,
    ':id_cours' => $id_cours,
    ':session_orig' => $session_orig,
    ':annee_orig' => $annee_orig
]);
$inscription = $stmt->fetch();

if (!$inscription) {
    header("Location: inscriptions.php");
    exit;
}
?>

    <h2>Modifier inscription</h2>

<?php if (isset($erreur)): ?>
    <p style="color: red;"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

    <p><strong>Étudiant:</strong> <?= htmlspecialchars($inscription['nom_etudiant']) ?></p>
    <p>
        <strong>Cours:</strong> <?= htmlspecialchars($inscription['numero_cours'] . ' - ' . $inscription['titre_cours']) ?>
    </p>
    <p>Modification de l'inscription pour la session **<?= htmlspecialchars($inscription['session']) ?>** de l'année
        **<?= htmlspecialchars($inscription['annee']) ?>**.</p>

    <form method="post" action="">
        <select name="session" required>
            <option value="AUT" <?= $inscription['session'] == 'AUT' ? 'selected' : '' ?>>Automne</option>
            <option value="HIV" <?= $inscription['session'] == 'HIV' ? 'selected' : '' ?>>Hiver</option>
            <option value="ETE" <?= $inscription['session'] == 'ETE' ? 'selected' : '' ?>>Été</option>
        </select>

        <input type="number" name="annee" value="<?= htmlspecialchars($inscription['annee']) ?>"
               placeholder="Année" min="2000" max="2100" required>

        <input type="number" name="note" value="<?= htmlspecialchars($inscription['note']) ?>"
               placeholder="Note" step="0.01" min="0" max="100">

        <input type="submit" value="Modifier">
        <a href="inscriptions.php">Annuler</a>
    </form>

<?php include 'footer.php'; ?>