<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../controller/ControllerCertificat.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $data = [
        'id' => $_POST['id'],
        'nom_enfant' => $_POST['nom_enfant'],
        'date_naissance' => $_POST['date_naissance'],
        'heure_naissance' => $_POST['heure_naissance'],
        'lieu_naissance' => $_POST['lieu_naissance'],
        'sexe' => $_POST['sexe'],
        'nom_mere' => $_POST['nom_mere'],
        'nationalite_mere' => $_POST['nationalite_mere'],
        'adresse_mere' => $_POST['adresse_mere'],
        'profession_mere' => $_POST['profession_mere']
    ];

    $pdo = db_connect();

    $stmt = $pdo->prepare("
        UPDATE certificats_naissance SET
            nom_enfant = :nom_enfant,
            date_naissance = :date_naissance,
            heure_naissance = :heure_naissance,
            lieu_naissance = :lieu_naissance,
            sexe = :sexe,
            nom_mere = :nom_mere,
            nationalite_mere = :nationalite_mere,
            adresse_mere = :adresse_mere,
            profession_mere = :profession_mere
        WHERE id = :id
    ");

    if ($stmt->execute($data)) {
        header("Location: listCertificat.php");
        exit();
    } else {
        $message = "Erreur lors de la modification.";
    }
}

if (isset($_GET['id'])) {
    $certificat = get_certificat($_GET['id']);
} else {
    $message = "ID du certificat manquant.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Certificat</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: rgba(0, 0, 0, 0.11);">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1>Modifier un Certificat de Naissance</h1>
        <a href="listCertificat.php" class="btn btn-primary">Retour</a>
    </div>
    <?php if (isset($message)): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>
 
    <form method="post" action="edit.php" class="group-form mt-5 mb-5">

        <input type="hidden" name="id" value="<?= htmlspecialchars($certificat['id']) ?>">

        <!-- Réutilisez les champs du formulaire d'enregistrement avec les valeurs existantes -->
        <div class="mb-3">
            <label for="nom_enfant" class="form-label">Nom de l'Enfant</label>
            <input type="text" name="nom_enfant" id="nom_enfant" class="form-control" value="<?= htmlspecialchars($certificat['nom_enfant']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="date_naissance" class="form-label">Date de Naissance</label>
            <input type="date" name="date_naissance" id="date_naissance" class="form-control" value="<?= htmlspecialchars($certificat['date_naissance']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="heure_naissance" class="form-label">Heure de Naissance</label>
            <input type="time" name="heure_naissance" id="heure_naissance" class="form-control" value="<?= htmlspecialchars($certificat['heure_naissance']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="lieu_naissance" class="form-label">Lieu de Naissance</label>
            <input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control" value="<?= htmlspecialchars($certificat['lieu_naissance']) ?>" required>
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
            <input type="text" name="nom_mere" id="nom_mere" class="form-control" value="<?= htmlspecialchars($certificat['nom_mere']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="nationalite_mere" class="form-label">Nationalité de la Mère</label>
            <input type="text" name="nationalite_mere" id="nationalite_mere" class="form-control" value="<?= htmlspecialchars($certificat['nationalite_mere']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="adresse_mere" class="form-label">Adresse de la Mère</label>
            <input type="text" name="adresse_mere" id="adresse_mere" class="form-control" value="<?= htmlspecialchars($certificat['adresse_mere']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="profession_mere" class="form-label">Profession de la Mère</label>
            <input type="text" name="profession_mere" id="profession_mere" class="form-control" value="<?= htmlspecialchars($certificat['profession_mere']) ?>">
        </div>
        <!-- Ajoutez les autres champs ici -->
        <button type="submit" class="btn btn btn-success">Modifier</button>
        
    </form>
</div>
</body>
</html>
