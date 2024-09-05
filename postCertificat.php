<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'controller/ControllerCertificat.php';

if(!isset($_GET["id"]) || empty($_GET["id"]) ){
    header("index.php");
}
$id=$_GET["id"];
$certificat= post_certificat($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>certificat</title>
</head>
<body>
    
    <center>
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
                <tr>
                    <td><?= $certificat['id'] ?></td>
                    <td><?= $certificat['nom_enfant'] ?></td>
                    <td><?= $certificat['date_naissance'] ?></td>
                    <td><?= $certificat['lieu_naissance'] ?></td>
                    <td><?= $certificat['sexe'] ?></td>
                    <td><?= $certificat['nom_mere'] ?></td>
                    <td><?= $certificat['date_enregistrement'] ?></td>
                    <td><?= $certificat['numero_enregistrement'] ?></td>
                </tr>
            </tbody>
        </table>
        <div>
            <a href="genpdf.php?id=<?= htmlspecialchars($certificat['id']) ?>" class="btn btn-warning btn-sm mb-1">telecharger</a>
        </div>
    </center>

</body>
</html>