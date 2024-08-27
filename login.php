<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'controller/ControllerCertificat.php';


if (!empty($_POST['name_user']) && !empty($_POST['password_user'])) {
    $get_request=[
        'name_user' => htmlspecialchars($_POST['name_user']),
        "password_user" => htmlspecialchars($_POST['password_user'])
    ];

    login_user($get_request);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrer un Certificat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Enregistrer un Certificat de Naissance</h1>
        <a href="listCertificats.php" class="btn btn-success">Retour</a>
    </div>
    
    <?php if (isset($message)): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>
    <form class="mb-4" method="post" action="index.php">        
        <div class="mb-3">
            <label for="name_user" class="form-label">mot de l'utilisateur</label>
            <input type="text" name="name_user" id="name_user" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password_user" class="form-label">mot de passe utilisateur</label>
            <input type="text" name="password_user" id="password_user" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">connecte moi</button>
    </form>
</div>
</body>
</html>