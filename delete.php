<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'controller/ControllerCertificat.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $pdo = db_connect();
    
    $stmt = $pdo->prepare("DELETE FROM certificats_naissance WHERE id = :id");
    if ($stmt->execute(['id' => $id])) {
        header("Location: index.php");
        exit();
    } else {
        $message = "Erreur lors de la suppression.";
    }
} else {
    $message = "ID du certificat manquant.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression du Certificat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Suppression du Certificat</h1>
    <?php if (isset($message)): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>
</div>
</body>
</html>
