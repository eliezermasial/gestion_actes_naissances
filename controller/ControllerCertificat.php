<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'dataBase/config_db.php';

/**
 * Login connexion de l'utilisateur.
 * 
 *@param int $get_request Les request de verifications de l'utilisateur pour se connecter.
 * @return array Un tableau associatif contenant les certificats de naissance par id.
 */
function login_user($get_request) {
    $pdo = db_connect();

    $stmt = "SELECT * FROM user";
    $select= $pdo ->query($stmt);
    $recupereUser = $select -> fetch();

    if($get_request['name_user'] === $recupereUser['name_user'] && 
        $get_request['password_user'] === $recupereUser['password_user']
    )
    {
        header("Location: listCertificat.php");
    }
    else{
        header("Location: index.php");
    }
}

/**
 * Enregistre un certificat de naissance dans la base de données.
 *
 * @param array $data Les données du certificat à enregistrer.
 * @return bool Retourne vrai si l'enregistrement a réussi, sinon faux.
 */
function enregistrer_certificat($data) {
    $pdo = db_connect();
    
    $stmt = $pdo->prepare("
        INSERT INTO certificats_naissance (
            nom_enfant, date_naissance, heure_naissance, 
            lieu_naissance, sexe, nom_mere, nationalite_mere, 
            adresse_mere, profession_mere, date_enregistrement, numero_enregistrement
        ) VALUES (
            :nom_enfant, :date_naissance, :heure_naissance, 
            :lieu_naissance, :sexe, :nom_mere, :nationalite_mere, 
            :adresse_mere, :profession_mere, :date_enregistrement, :numero_enregistrement
        )
    ");

    return $stmt->execute($data);
}

/**
 * Récupère tous les certificats de naissance de la base de données.
 *
 * @return array Un tableau associatif contenant les certificats de naissance.
 */
function get_certificats() {
    $pdo = db_connect();
    $stmt = $pdo->query("SELECT * FROM certificats_naissance ORDER BY date_enregistrement ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Récupère un certificat de naissance spécifique par son ID.
 *
 * @param int $id L'ID du certificat à récupérer.
 * @return array|null Un tableau associatif contenant les données du certificat, ou null si non trouvé.
 */
function get_certificat($id) {
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT * FROM certificats_naissance WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


/**
 * Suppression de certificats de naissance par Id.
 * 
 *@param int $id L'identifiant du certificat à psupprimer.
 * @return bool Retourne vrai si le certificat est supprimé , sinon faux.
 */
function delete_certificat($id,$message) {
    $pdo = db_connect();
    $stmt = $pdo->prepare("DELETE FROM certificats_naissance WHERE id = :id");

    if ($stmt->execute(['id' => $id])) {
        header("Location: index.php");
        exit();
    } else {
        $message = "Erreur lors de la suppression.";
    }
}

/**
 * Récupère le certificats de naissance correspondant à l'Id de la base de données.
 * 
 *@param int $id L'identifiant du certificat à poster.
 * @return array Un tableau associatif contenant les certificats de naissance par id.
 */
function post_certificat($id) {
    
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT * FROM certificats_naissance WHERE id = :id");
    $stmt -> bindValue(":id",$id,PDO::PARAM_INT);
    $stmt -> execute();
    return $stmt->fetch();
}

?>