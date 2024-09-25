<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'controller/ControllerCertificat.php';

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];
$certificat = post_certificat($id);

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
    <title>certificat de <?= $certificat['nom_enfant'] ?> </title>
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
        
        <!-- Logo de l'hôpital à droite (pour un effet professionnel comme l'image d'exemple) -->
        <div >
            <svg  version="1.1" id="Capa_1" width="100px" viewBox="0 0 118.624 118.624">
           <g>
               <path d="M45.192,24.437v15.297H29.896c-1.546,0-2.802,1.256-2.802,2.802V65.17c0,1.554,1.256,2.802,2.802,2.802h15.296v15.294
                   c0,1.537,1.256,2.802,2.802,2.802h22.638c1.537,0,2.802-1.265,2.802-2.802V67.972h15.288c1.549,0,2.802-1.248,2.802-2.802V42.535
                   c0-1.546-1.253-2.802-2.802-2.802H73.434V24.437c0-1.545-1.265-2.801-2.802-2.801H47.994
                   C46.448,21.636,45.192,22.891,45.192,24.437z M50.796,42.541V27.244H67.83v15.297c0,1.549,1.253,2.801,2.802,2.801H85.92V62.38
                   H70.632c-1.549,0-2.802,1.253-2.802,2.802V80.47H50.796V65.182c0-1.549-1.256-2.802-2.802-2.802H32.698V45.342h15.296
                   C49.546,45.342,50.796,44.095,50.796,42.541z M117.179,15.288C100.021,5.829,80.017,0.83,59.312,0.83
                   c-20.708,0-40.72,5.005-57.865,14.458c-0.958,0.531-1.52,1.567-1.44,2.667c3.182,42.876,24.825,80.058,57.889,99.462
                   c0.439,0.262,0.93,0.377,1.416,0.377c0.489,0,0.98-0.115,1.418-0.377c33.064-19.404,54.717-56.597,57.886-99.467
                   C118.697,16.845,118.136,15.807,117.179,15.288z M59.312,111.726C29.094,93.309,9.199,58.992,5.74,19.329
                   C21.705,10.876,40.178,6.422,59.312,6.422c19.122,0,37.602,4.454,53.574,12.906C109.434,58.992,89.543,93.301,59.312,111.726z"/>
           </g>
           </svg>
        </div>
    
        <div class="header">
            <h6>REPUBLIQUE DEMOCRATIQUE DU CONGO</h6>
            <h6>ENSEIGNEMENT SUPERIEUR ET UNIVERSITAIRE</h6>
            <h6>ISTM / KIN</h6>
            <h6>HOPITAL DE N'DJILI</h6>
            <p>Q/7 Kinshasa - N'djili</p>
            <h5 class="fw-bold">CERTIFICAT DE NAISSANCE</h5>
        </div>
        
        <div class="content mt-5">
            <p>Je soussigné : <span class="input-line text-center"><?= $certificat['nom_enfant'] ?></span></p>
            <p>Certifie que Madame : <span class="input-line"><?= $certificat['nom_mere'] ?></span></p>
            <p>Epouse de Monsieur : <span class="input-line"></span></p>
            <p>a accouché le : <span class="input-line"><?= $certificat['date_enregistrement'] ?></span></p>
            <p>liéu de naissance : <span class="input-line"><?= $certificat['lieu_naissance'] ?></span></p>
            <p>Sexe   :  <span class="input-line "><?= $certificat['sexe'] ?></span></p>
            <p>VA P.O : <span class="input-line "></span></p>
            <p>Numero d'enregistreent : <span class="input-line "><?= $certificat['numero_enregistrement'] ?></span></p>
            <p>Rendez-vous : <span class="input-line"></span></p>
        </div>
        
        <div class="signature-section mt-3">
            <div class="left">
                <p>Cachet :</p> <!-- Correction du mot "Cachet" pour l'alignement -->
            </div>
            <div class="right text-end">
                <p>Dr : .............................</p>
                <p>CNO: 2780</p>
                <p>Date et Signature</p>
            </div>
        </div>
    </div>
    
    <div class="content_telecharger mb-5">
        <a class="btn" href="genpdf.php?id=<?= htmlspecialchars($certificat['id']) ?>">telecharcher</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

