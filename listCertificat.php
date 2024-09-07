<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'controller/ControllerCertificat.php';

$certificats = get_certificats();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Certificats de Naissance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>Liste des Certificats de Naissance</h1>
        <a href="enregistrer.php" class="btn btn-success">Enregistrer un Nouveau Certificat</a>
    </div>
    <table class="table table-bordered mt-5">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom de l'Enfant</th>
            <th>Date de Naissance</th>
            <th>Lieu de Naissance</th>
            <th>Sexe</th>
            <th>Nom de la Mère</th>
            <th>Date d'Enregistrement</th>
            <th>Numéro d'Enregistrement</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($certificats as $certificat): ?>
            <tr>
                <td><?= $certificat['id'] ?></td>
                <td><?= htmlspecialchars($certificat['nom_enfant']) ?></td>
                <td><?= htmlspecialchars($certificat['date_naissance']) ?></td>
                <td><?= htmlspecialchars($certificat['lieu_naissance']) ?></td>
                <td><?= htmlspecialchars($certificat['sexe']) ?></td>
                <td><?= htmlspecialchars($certificat['nom_mere']) ?></td>
                <td><?= htmlspecialchars($certificat['date_enregistrement']) ?></td>
                <td><?= htmlspecialchars($certificat['numero_enregistrement']) ?></td>
                <td>
                    <a href="edit.php?id=<?= htmlspecialchars($certificat['id']) ?>" class="btn btn-warning btn-sm mb-1">Edite</a>
                    <a href="postCertificat.php?id=<?= htmlspecialchars($certificat['id']) ?>" class="btn btn-warning btn-sm mb-1">voir certificat</a>
                    <a href="delete.php?id=<?= htmlspecialchars($certificat['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce certificat ?');">delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>

