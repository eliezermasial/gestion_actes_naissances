<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../controller/Controller.php';

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];
$enfant = getEnfantDetails($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/certificat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>certificat de <?= $enfant['nom_enfant'] ?> </title>
</head>
<style>
    .certificat {
    width: 550px;
    margin: 50px auto;
    padding: 20px;
    border: 2px solid #e60000b6; /* Bordure rouge comme dans l'image */
    background-color: #ffffff94; /* Fond blanc pour ressembler à un papier */
    position: relative;
    box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.596); /* Légère ombre pour un effet pro */
}
.header, .footer {
    text-align: center;
    margin-bottom: 20px;
}
.header h6 {
    color: #0033cc; /* Police bleue comme dans l'image */
    font-weight: bold;
}
.header h5 {
    color: #e60000; /* Titre en rouge pour correspondre au style du certificat d'exemple */
    font-weight: bold;
}
.content {
    margin-bottom: 20px;
}
.input-line {
    border-bottom: 1px solid #3333335b; /* Lignes plus visibles */
    display: inline-block;
    width: 100%;
}

.signature-section {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}
.signature-section .left, .signature-section .right {
    width: 45%;
    text-align: left;
}
.footer {
    margin-top: 30px;
}
.icon {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 50px;
    height: 50px;
}
svg {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 50px;
    fill: #e60000;
    stroke: #e60000;
}
.content_telecharger {
    text-align: center;
}
.content_telecharger a {
    --bs-btn-color: #fff
    ;
    --bs-btn-bg: #198754;
    --bs-btn-border-color: #198754;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #fff;
    --bs-btn-hover-border-color: #fff;
    --bs-btn-focus-shadow-rgb: 60, 153, 110;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: #146c43;
    --bs-btn-active-border-color: #13653f;
    --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: #198754;
    --bs-btn-disabled-border-color: #198754;
}
@font-face {
    font-family: 'FontAwesome';
    src: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/webfonts/fa-solid-900.woff2') format('woff2');
}

</style>
<body>
<div class="container mt-5">
    <div class="certificat">
        <!-- Icone du certificat à gauche (similaire à l'exemple du certificat de formation) -->
        <svg class="icon" viewBox="0 0 20 20" >
        
            <title>hospital [#1214]</title>
            <desc>Created with Sketch.</desc>
            <defs>
        
        </defs>
            <g id="Page-1" stroke="#e60000" stroke-width="1" fill="#e60000" fill-rule="evenodd">
                <g id="Dribbble-Light-Preview" transform="translate(-380.000000, -2719.000000)" fill="#FFFFF">
                    <g id="icons" transform="translate(56.000000, 160.000000)">
                        <path d="M333,2573 L331,2573 L331,2565 L333,2565 L333,2568 L335,2568 L335,2565 L337,2565 L337,2573 L335,2573 L335,2570 L333,2570 L333,2573 Z M326,2577 L342,2577 L342,2561 L326,2561 L326,2577 Z M324,2579 L344,2579 L344,2559 L324,2559 L324,2579 Z" id="hospital-[#1214]">
        
        </path>
                    </g>
                </g>
            </g>
        </svg>
        
    
        <div class="header">
            <h6>REPUBLIQUE DEMOCRATIQUE DU CONGO</h6>
            <h6>HOPITAL DE N'DJILI</h6>
            <p>Q/7 Kinshasa - N'djili</p>
            <h5 class="fw-bold">CERTIFICAT DE NAISSANCE</h5>
        </div>
        
        <div class="content pt-3">
            <p>Je soussigné : <span class="text-start"><?= $enfant['nom_enfant'].' '.$enfant['postnom_enfant'].' '.$enfant['prenom_enfant']  ?></span></p>
            <p>Certifie que Madame : <?= $enfant['nom_mere'].' '.$enfant['postnom_mere'].' '.$enfant['prenom_mere'] ?></p>
            <p>Epouse de Monsieur : <?= $enfant['nom_pere'].' '.$enfant['postnom_pere'].' '.$enfant['prenom_pere'] ?></p>
            <p>a accouché le : <?= $enfant['date_naissance_enfant'].' '.'à'.' '.$enfant['heure_naissance_enfant'] ?></p>
            <div class="d-flex justify-content-around">
            <p>Sexe   :  <?= $enfant['sexe_enfant'] ?></p>
            <p>Poids : <?= $enfant['poids_enfant'] ?></p>
            </div>
            <div class="d-flex justify-content-around mb-2">
                <label>vaccin bcg:
                    <input type="checkbox" <?= $enfant['vaccin_bcg'] == 1 ? 'checked' : '' ?> disabled>
                </label>
                <label>vaccin polio: 
                    <input type="checkbox" <?= $enfant['vaccin_polio'] == 1 ? 'checked' : ''?> disabled>
                </label>
            </div>
            <p>Rendez-vous : ..................</p>
            <p>Numero d'enregistreent : <?= $enfant['numero_certificat'] ?></p>
        </div>
        
        <div class="d-flex justify-content-between">
            <div class="">
            <p>Date et Signature : .....</p>
                <p>Cachet :</p> <!-- Correction du mot "Cachet" pour l'alignement -->
            </div>
            <div class="text-end">
                <p>Dr : <?= $enfant['nom_medecin'].' '.$enfant['postnom_medecin'] ?></p>
                <p>Tel: <?= $enfant['contact_medecin'] ?></p>
            </div>
        </div>
    </div>
    
    <div class="content_telecharger mb-5">
        <a class="btn" href="genpdf.php?id=<?= htmlspecialchars($enfant['enfant_id']) ?>">telecharcher</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

