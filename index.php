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
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asserts/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>login</title>
</head>
<body style="background-color: black;">
    <div class="anime"></div>
    <div class="form-container">
    <?php if (isset($message)): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>
        <form method="post" action="index.php">
            <h1>connexion</h1>
            <div class="form-group">
                <input type="text" name="name_user" id="name_user" autocomplete="off">
                <label for="">nom utilisateur</label>
                <span>
                    <i class="fa-regular fa-envelope"></i>
                </span>
            </div>
            <div class="form-group">
                <input type="password" name="password_user" id="password_user" required>
                <label for="">mot de passe utilisateur</label>
                <span>
                    <i class="fa-solid fa-lock"></i>
                </span>
            </div>
            
            <div class="form-option">  
                <label for=""><input type="checkbox" required>Remember me</label>
                <a href="#">mot de passe oublié ?</a>
            </div>
            <button type="submit">se connecté</button>
            <div class="registe">
                <p>vous n'avez pas de compte ? <a href="#">nous rejoindre</a></p>
            </div>
        </form>
    </div>
</body>
</html>