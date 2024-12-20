<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//require_once 'controller/ControllerCertificat.php';
require_once '../controller/controller.php';


$enfant = getEnfantDetails($_GET['id']) ;

$id = $_POST['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']))
{
  $dataEnfant = [
    'mere_id' => '',
    'pere_id' => '',
    'medecin_id' => '',
    'naissance_id' => '',
    'sexe' => $_POST['sexe'],
    'nom' => $_POST['nom_enfant'],
    'poids' => $_POST['poids_enfant'],
    'lastName' => $_POST['prenom_enfant'],
    'firstName' => $_POST['postnom_enfant'],
  ];
  
  $dataMere = [
    'nom' => $_POST['nom_mere'],
    'lastName' => $_POST['prenom_mere'],
    'adresse' => $_POST['adresse_mere'],//123 Rue Exemple
    'contact' => $_POST['contact_mere'],
    'firstName' => $_POST['postnom_mere'],
    'profession' => $_POST['profession_mere'],//Infirmière
    'nationalite' => $_POST['nationalite_mere'],
    'date_naissance' => $_POST['date_naissance_mere'],//1980-01-01
    'lieu_naissance' => $_POST['lieu_naissance_mere'],
  ];
  
  $dataPere = [
    'nom' => $_POST['nom_pere'],
    'lastName' => $_POST['prenom_pere'],
    'adresse' => $_POST['adresse_pere'],
    'contact' => $_POST['contact_pere'],
    'firstName' => $_POST['postnom_pere'],
    'profession' => $_POST['profession_pere'],
    'nationalite' => $_POST['nationalite_pere'],
    'date_naissance' => $_POST['date_naissance_pere'],
    'lieu_naissance' => $_POST['lieu_naissance_pere']
  ];
  
  $dataNaissance = [
    'heure' => $_POST['heure_naissance_enfant'],
    'dateNaissance' => $_POST['data_naissance_enfant'],
    'lieu_naissance' => $_POST['lieu_naissance_enfant']
  ];

 $dataMedecin = [
    'nom' => $_POST['nom_medecin'],
    'contact' => $_POST['contact_medecin'],
    'specialisation' => $_POST['specialisation'],
    'postnom_medecin' => $_POST['postnom_medecin']
  ];

$enfant = updateEnfant($id, $dataEnfant, $dataMere, $dataPere, $dataNaissance, $dataMedecin);

}

if (isset($_GET['id'])) {
  $enfant = getEnfantDetails($_GET['id']) ;
} else {
  $message = "ID du certificat manquant.";
}


if (isset($_GET['id'])) {
    $certificat = getEnfantDetails($_GET['id']);
} else {
    $message = "ID du certificat manquant.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title> Modifier les informations de <?= $enfant['nom_enfant'] ?></title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/typicons.font/font/typicons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../../vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">

</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <!--<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="../../index.html"><img src="../../images/logo.svg" alt="logo"/></a>
          <a class="navbar-brand brand-logo-mini" href="../../index.html"><img src="../../images/logo-mini.svg" alt="logo"/></a>
          <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button" data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
          </button>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
          <ul class="navbar-nav mr-lg-2">
            <li class="nav-item  d-none d-lg-flex">
              <a class="nav-link" href="#">
                Calendar
              </a>
            </li>
            <li class="nav-item  d-none d-lg-flex">
              <a class="nav-link active" href="#">
                Statistic
              </a>
            </li>
            <li class="nav-item  d-none d-lg-flex">
              <a class="nav-link" href="#">
                Employee
              </a>
            </li>
          </ul>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item d-none d-lg-flex  mr-2">
              <a class="nav-link" href="#">
                Help
              </a>
            </li>
            <li class="nav-item dropdown d-flex">
              <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-toggle="dropdown">
                <i class="typcn typcn-message-typing"></i>
                <span class="count bg-success">2</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="../../images/faces/face4.jpg" alt="image" class="profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow">
                    <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                    </h6>
                    <p class="font-weight-light small-text mb-0">
                      The meeting is cancelled
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="../../images/faces/face2.jpg" alt="image" class="profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow">
                    <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                    </h6>
                    <p class="font-weight-light small-text mb-0">
                      New product launch
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <img src="../../images/faces/face3.jpg" alt="image" class="profile-pic">
                  </div>
                  <div class="preview-item-content flex-grow">
                    <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                    </h6>
                    <p class="font-weight-light small-text mb-0">
                      Upcoming board meeting
                    </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item dropdown  d-flex">
              <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="typcn typcn-bell mr-0"></i>
                <span class="count bg-danger">2</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="typcn typcn-info-large mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Application Error</h6>
                    <p class="font-weight-light small-text mb-0">
                      Just now
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="typcn typcn-cog mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">Settings</h6>
                    <p class="font-weight-light small-text mb-0">
                      Private message
                    </p>
                  </div>
                </a>
                <a class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="typcn typcn-user-outline mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                    <p class="font-weight-light small-text mb-0">
                      2 days ago
                    </p>
                  </div>
                </a>
              </div>
            </li>
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
                <i class="typcn typcn-user-outline mr-0"></i>
                <span class="nav-profile-name">Evan Morales</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item">
                <i class="typcn typcn-cog text-primary"></i>
                Settings
                </a>
                <a class="dropdown-item">
                <i class="typcn typcn-power text-primary"></i>
                Logout
                </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="typcn typcn-th-menu"></span>
          </button>
        </div>
      </nav>
    partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_settings-panel.html -->
      <div class="theme-setting-wrapper">
          <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
          <div id="theme-settings" class="settings-panel">
            <i class="settings-close typcn typcn-delete-outline"></i>
            <p class="settings-heading">SIDEBAR SKINS</p>
            <div class="sidebar-bg-options" id="sidebar-light-theme">
              <div class="img-ss rounded-circle bg-light border mr-3"></div>
              Light
            </div>
            <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
              <div class="img-ss rounded-circle bg-dark border mr-3"></div>
              Dark
            </div>
            <p class="settings-heading mt-2">HEADER SKINS</p>
            <div class="color-tiles mx-0 px-4">
              <div class="tiles success"></div>
              <div class="tiles warning"></div>
              <div class="tiles danger"></div>
              <div class="tiles primary"></div>
              <div class="tiles info"></div>
              <div class="tiles dark"></div>
              <div class="tiles default border"></div>
            </div>
          </div>
        </div>
      <!-- partial -->

      <!-- partial:../../partials/sidebar -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <div class="nav-search mt-2">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Type to search..." aria-label="search" aria-describedby="search">
                <div class="input-group-append">
                  <span class="input-group-text" id="search">
                    <i class="typcn typcn-zoom"></i>
                  </span>
                </div>
              </div>
            </div>
            <p class="sidebar-menu-title">Dash menu</p>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="listCertificat.php">
              <i class="typcn typcn-device-desktop menu-icon"></i>
              <span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
              <i class="typcn typcn-film menu-icon"></i>
              <span class="menu-title">Form</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="enregistrer.php">Enregistrer </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
              <i class="typcn typcn-th-small-outline menu-icon"></i>
              <span class="menu-title">Tables</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../pages/tables/basic-table.html">Basic table</a></li>
              </ul>
            </div>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="typcn typcn-user-add-outline menu-icon"></i>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register.html"> Register </a></li>
              </ul>
            </div>
          </li>
         
        </ul>
      </nav>
      
      <!-- partial -->
      <div class="main-panel">        
      <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Modifier les informations d'un Enfant</h4>
                  <?php if (isset($message)): ?>
                    <div class="alert alert-danger"><?= $message ?></div>
                  <?php endif; ?>
                  <form class="form-sample" action="edit.php" method="Post">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nom enfant</label>
                          <div class="col-sm-9">
                            <input type="text" name="nom_enfant" id="nom_enfant" class="form-control" value="<?= $enfant['nom_enfant'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Post-nom</label>
                          <div class="col-sm-9">
                            <input type="text" name="postnom_enfant" id="postnom_enfant" class="form-control" value="<?= $enfant['postnom_enfant'] ?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Pre-nom</label>
                          <div class="col-sm-9">
                            <input type="text" name="prenom_enfant" id="prenom_enfant" class="form-control" value="<?= $enfant['prenom_enfant'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date de Naissance Enfant</label>
                          <div class="col-sm-9">
                            <input type="date" name="date_naissance_enfant" id="date_naissance_enfant" class="form-control" value="<?= $enfant['date_naissance_enfant'] ?>" required />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Heure de naissance</label>
                          <div class="col-sm-9">
                            <input type="time" name="heure_naissance_enfant" id="heure_naissance_enfant" class="form-control" value="<?= $enfant['heure_naissance_enfant'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Lieu de naissance enfant</label>
                          <div class="col-sm-9">
                            <input type="text" name="lieu_naissance_enfant" id="lieu_naissance_enfant" class="form-control" value="<?= $enfant['lieu_naissance_enfant'] ?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nom de Mere</label>
                          <div class="col-sm-9">
                            <input type="text" name="nom_mere" id="nom_mere" class="form-control" value="<?= $enfant['nom_mere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nom du Pere</label>
                          <div class="col-sm-9">
                            <input type="text" name="nom_pere" id="nom_pere" class="form-control" value="<?= $enfant['nom_pere'] ?>" required />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Postnom de Mere</label>
                          <div class="col-sm-9">
                            <input type="text" name="postnom_mere" id="postnom_mere" class="form-control" value="<?= $enfant['postnom_mere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Postnom du Pere</label>
                          <div class="col-sm-9">
                            <input type="text" name="postnom_pere" id="postnom_pere" class="form-control" value="<?= $enfant['postnom_pere'] ?>" required />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Pre-nom de Mere</label>
                          <div class="col-sm-9">
                            <input type="text" name="prenom_mere" id="prenom_mere" class="form-control" value="<?= $enfant['prenom_pere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Pre-nom du Pere</label>
                          <div class="col-sm-9">
                            <input type="text" name="prenom_pere" id="prenom_pere" class="form-control" value="<?= $enfant['prenom_mere'] ?>" required />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Adresse de pere</label>
                          <div class="col-sm-9">
                            <input type="text" name="adresse_pere" id="adresse_pere" class="form-control" value="<?= $enfant['adresse_pere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Adresse de mere</label>
                          <div class="col-sm-9">
                            <input type="text" name="adresse_mere" id="adresse_mere" class="form-control" value="<?= $enfant['adresse_mere']?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date de Naissance du pere</label>
                          <div class="col-sm-9">
                            <input type="date" name="date_naissance_pere" id="date_naissance_pere" class="form-control" value="<?= $enfant['date_naissance_pere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date de Naissance de la mere</label>
                          <div class="col-sm-9">
                            <input type="date" name="date_naissance_mere" id="date_naissance_mere" class="form-control" value="<?= $enfant['date_naissance_mere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Lieu de Naissance du pere</label>
                          <div class="col-sm-9">
                            <input type="text" name="lieu_naissance_pere" id="lieu_naissance_pere" class="form-control" value="<?= $enfant['lieu_naissance_pere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Lieu de Naissance de la mere</label>
                          <div class="col-sm-9">
                            <input type="text" name="lieu_naissance_mere" id="lieu_naissance_mere" class="form-control" value="<?= $enfant['lieu_naissance_mere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Profession du Père</label>
                          <div class="col-sm-9">
                            <input type="text" name="profession_pere" id="profession_pere" class="form-control" value="<?= $enfant['profession_pere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Profession de Mère</label>
                          <div class="col-sm-9">
                            <input type="text" name="profession_mere" id="profession_mere" class="form-control" value="<?= $enfant['profession_mere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nationalité du Père</label>
                          <div class="col-sm-9">
                            <input type="text" name="nationalite_pere" id="nationalite_pere" class="form-control" value="<?= $enfant['nationalite_pere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nationalité de Mère</label>
                          <div class="col-sm-9">
                            <input type="text" name="nationalite_mere" id="nationalite_mere" class="form-control" value="<?= $enfant['nationalite_mere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Contact du Père</label>
                          <div class="col-sm-9">
                            <input type="text" name="contact_pere" id="contact_pere" class="form-control" value="<?= $enfant['contact_pere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Contact de Mère</label>
                          <div class="col-sm-9">
                            <input type="text" name="contact_mere" id="contact_mere" class="form-control" value="<?= $enfant['contact_mere'] ?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Sexe</label>
                          <div class="col-sm-9">
                          <select name="sexe" id="sexe" class="form-select" required>
                            <option value="M">Masculin</option>
                            <option value="F">Féminin</option>
                          </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Poid</label>
                          <div class="col-sm-9">
                            <input type="text" name="poids_enfant" id="poids_enfant" class="form-control" value="<?= $enfant['poids_enfant'] ?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Nom de medecin</label>
                          <div class="col-sm-9">
                            <input type="text" name="nom_medecin" id="nom_medecin" class="form-control" value="<?= $enfant['nom_medecin'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Postnom de medecin</label>
                          <div class="col-sm-9">
                            <input type="text" name="postnom_medecin" id="postnom_medecin" class="form-control" value="<?= $enfant['postnom_medecin'] ?>" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Spécialité de medecin</label>
                          <div class="col-sm-9">
                            <input type="text" name="specialisation" id="specialisation" class="form-control" value="<?= $enfant['specialisation'] ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Contact de medecin</label>
                          <div class="col-sm-9">
                            <input type="text" name="contact_medecin" id="contact_medecin" class="form-control" value="<?= $enfant['contact_medecin'] ?>" required/>
                            <input type="hidden" name="id" id="id" value="<?= $enfant['enfant_id'] ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                  </form>
                </div>
              </div>
            </div>

          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com</a> 2020</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard </a>templates from Bootstrapdash.com</span>
            </div>
          </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../../vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/file-upload.js"></script>
  <script src="../../js/typeahead.js"></script>
  <script src="../../js/select2.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
