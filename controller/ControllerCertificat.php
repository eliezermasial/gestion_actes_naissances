<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'dataBase/config_db.php';

/**
 * Login connexion de l'utilisateur.
 * 
 *@param int $get_request Les request de vérifications de l'utilisateur pour se connecter.
 * @return array Un tableau associatif contenant les certificats de naissance par id.
 */
function login_user($get_request) {
    $pdo = db_connect(); // Connexion à la base de données via une fonction db_connect()

    $stmt = "SELECT * FROM user"; // Préparation de la requête SQL pour récupérer tous les utilisateurs (à améliorer)
    $select = $pdo->query($stmt); // Exécution de la requête SQL
    $getUser = $select->fetch(); // Récupération du premier enregistrement de la table user

    // Comparaison des informations fournies avec celles de la base de données
    if ($get_request['name_user'] === $getUser['name_user'] && 
        $get_request['password_user'] === $getUser['password_user']) 
    {
        // Si les informations sont correctes, redirection vers listCertificat.php
        header("Location: listCertificat.php");
    }
    else {
        // Si les informations sont incorrectes, redirection vers index.php
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
    $pdo = db_connect(); // Connexion à la base de données via la fonction db_connect()

    // Préparation de la requête SQL pour insérer un nouveau certificat de naissance
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

    // Exécution de la requête avec les données fournies, retourne true si l'insertion réussit, sinon false
    return $stmt->execute($data); 
}


/**
 * Récupère tous les certificats de naissance de la base de données.
 *
 * @return array Un tableau associatif contenant les certificats de naissance.
 */
function get_certificats() {
    $pdo = db_connect(); // Connexion à la base de données via la fonction db_connect()

    // Exécution d'une requête SQL pour récupérer tous les certificats de naissance, triés par date d'enregistrement croissante
    $stmt = $pdo->query("SELECT * FROM certificats_naissance ORDER BY date_enregistrement ASC");

    // Retourne tous les enregistrements sous forme de tableau associatif
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}


/**
 * Récupère un certificat de naissance spécifique par son ID.
 *
 * @param int $id L'ID du certificat à récupérer.
 * @return array|null Un tableau associatif contenant les données du certificat, ou null si non trouvé.
 */
function get_certificat($id) {
    $pdo = db_connect(); // Connexion à la base de données via la fonction db_connect()

    // Préparation de la requête SQL pour récupérer un certificat en fonction de son ID
    $stmt = $pdo->prepare("SELECT * FROM certificats_naissance WHERE id = :id");

    // Exécution de la requête en passant l'ID en paramètre pour éviter les injections SQL
    $stmt->execute(['id' => $id]);

    // Récupère le certificat trouvé sous forme de tableau associatif, ou null si aucun certificat trouvé
    return $stmt->fetch(PDO::FETCH_ASSOC); 
}


/**
 * Suppression de certificats de naissance par Id.
 * 
 * @param int $id L'identifiant du certificat à supprimer.
 * @param string $message Un message à retourner en cas d'échec de la suppression.
 * @return bool Retourne vrai si le certificat est supprimé, sinon faux.
 */
function delete_certificat($id, &$message) { // Ajout de & pour passer $message par référence
    $pdo = db_connect(); // Connexion à la base de données via la fonction db_connect()

    // Préparation de la requête SQL pour supprimer un certificat en fonction de son ID
    $stmt = $pdo->prepare("DELETE FROM certificats_naissance WHERE id = :id");

    // Exécution de la requête en passant l'ID en paramètre pour éviter les injections SQL
    if ($stmt->execute(['id' => $id])) {
        // Si la suppression réussit, redirection vers la page d'accueil
        header("Location: index.php");
        exit(); // Terminer l'exécution du script après la redirection
    } else {
        // Si la suppression échoue, on modifie le message d'erreur
        $message = "Erreur lors de la suppression.";
    }
}


/**
 * Récupère le certificat de naissance correspondant à l'Id de la base de données.
 * 
 * @param int $id L'identifiant du certificat à récupérer.
 * @return array Un tableau associatif contenant le certificat de naissance correspondant à l'ID.
 */
function post_certificat($id) {
    $pdo = db_connect(); // Connexion à la base de données via la fonction db_connect()

    // Préparation de la requête SQL pour récupérer un certificat de naissance en fonction de son ID
    $stmt = $pdo->prepare("SELECT * FROM certificats_naissance WHERE id = :id");

    // Liaison de la valeur de l'ID à la requête en définissant son type comme entier (PDO::PARAM_INT)
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);

    // Exécution de la requête préparée
    $stmt->execute();

    // Récupération du certificat correspondant sous forme de tableau associatif
    return $stmt->fetch(); // Retourne false si aucun certificat n'est trouvé
}


?>