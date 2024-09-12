<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../controller/ControllerCertificat.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nom_enfant' => $_POST['nom_enfant'],
        'date_naissance' => $_POST['date_naissance'],
        'heure_naissance' => $_POST['heure_naissance'],
        'lieu_naissance' => $_POST['lieu_naissance'],
        'sexe' => $_POST['sexe'],
        'nom_mere' => $_POST['nom_mere'],
        'nationalite_mere' => $_POST['nationalite_mere'],
        'adresse_mere' => $_POST['adresse_mere'],
        'profession_mere' => $_POST['profession_mere'],
        'date_enregistrement' => date('Y-m-d'),
        'numero_enregistrement' => uniqid('CERT-')
    ];

    if (enregistrer_certificat($data)) {
        header("Location: index.php");
        exit();
    } else {
        $message = "Erreur lors de l'enregistrement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrer un Certificat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: rgba(0, 0, 0, 0.11);">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Enregistrer un Certificat de Naissance</h1>
        <a href="listCertificat.php" class="btn btn-primary">Retour</a>
    </div>
    
    <?php if (isset($message)): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>
    <form class="mb-4" method="post" action="enregistrer.php">
        <div class="mb-3">
            <label for="nom_enfant" class="form-label">Nom de l'Enfant</label>
            <input type="text" name="nom_enfant" id="nom_enfant" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="date_naissance" class="form-label">Date de Naissance</label>
            <input type="date" name="date_naissance" id="date_naissance" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="heure_naissance" class="form-label">Heure de Naissance</label>
            <input type="time" name="heure_naissance" id="heure_naissance" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="lieu_naissance" class="form-label">Lieu de Naissance</label>
            <input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="sexe" class="form-label">Sexe</label>
            <select name="sexe" id="sexe" class="form-select" required>
                <option value="M">Masculin</option>
                <option value="F">Féminin</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="nom_mere" class="form-label">Nom de la Mère</label>
            <input type="text" name="nom_mere" id="nom_mere" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nationalite_mere" class="form-label">Nationalité de la Mère</label>
            <input type="text" name="nationalite_mere" id="nationalite_mere" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="adresse_mere" class="form-label">Adresse de la Mère</label>
            <input type="text" name="adresse_mere" id="adresse_mere" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="profession_mere" class="form-label">Profession de la Mère</label>
            <input type="text" name="profession_mere" id="profession_mere" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
</body>
</html>