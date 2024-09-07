<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'dataBase/config_db.php';

/**
 * Lgin connexion de l'utilisateur.
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
 * Modifie un certificat de naissance dans la base de données.
 *
 * @param int $id L'identifiant du certificat à modifier.
 * @param array $data Les nouvelles données du certificat.
 * @return bool Retourne vrai si la modification a réussi, sinon faux.
 */
function modifier_certificat($id, $data) {
    $pdo = db_connect(); // Connexion à la base de données

    // Préparation de la requête SQL pour mettre à jour les informations du certificat
    $sql = "
        UPDATE certificats_naissance SET
            nom_enfant = :nom_enfant,
            date_naissance = :date_naissance,
            heure_naissance = :heure_naissance,
            lieu_naissance = :lieu_naissance,
            sexe = :sexe,
            nom_mere = :nom_mere,
            nationalite_mere = :nationalite_mere,
            adresse_mere = :adresse_mere,
            profession_mere = :profession_mere,
            date_enregistrement = :date_enregistrement,
            numero_enregistrement = :numero_enregistrement
        WHERE id = :id
    ";

    // Préparation de la requête
    $stmt = $pdo->prepare($sql);

    // Exécution de la requête avec les paramètres
    return $stmt->execute([
        'id' => $id,
        'nom_enfant' => $data['nom_enfant'],
        'date_naissance' => $data['date_naissance'],
        'heure_naissance' => $data['heure_naissance'],
        'lieu_naissance' => $data['lieu_naissance'],
        'sexe' => $data['sexe'],
        'nom_mere' => $data['nom_mere'],
        'nationalite_mere' => $data['nationalite_mere'],
        'adresse_mere' => $data['adresse_mere'],
        'profession_mere' => $data['profession_mere'],
        'date_enregistrement' => $data['date_enregistrement'],
        'numero_enregistrement' => $data['numero_enregistrement']
    ]);
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