<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//require_once 'controller/ControllerCertificat.php';
require_once '../controller/controller.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    deleteEnfant($id,$message);

} else {
    $message = "ID du certificat manquant.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Delete Certificat</title>
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
