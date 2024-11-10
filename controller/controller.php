<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'dataBase/pdo.php';

function enregistrementRequest(array $dataMere, array $dataPere, array $dataHopital, array $dataMedecin,$dataNaissance, $dataEnfant, $dataActNaissance /*array $dataMedecin array $dataNaissance, array $dataEnfant, array $dataActNaissance*/)
{
    try {
        $pdo = db_connect();
        $pdo->beginTransaction();
    
        // 1. Enregistrer la mère
        $stmt = $pdo->prepare(
            "INSERT INTO mere (nom, firstName, lastName, adresse, date_naissance, lieu_naissance, profession, nationalite, contact)
             VALUES (:nom, :firstName, :lastName, :adresse, :date_naissance, :lieu_naissance, :profession, :nationalite, :contact)"
        );
        $stmt->execute($dataMere);
        $id_mere = $pdo->lastInsertId();
    
        // 2. Enregistrer le père
        $stmt = $pdo->prepare(
            "INSERT INTO pere (nom, firstName, lastName, adresse, date_naissance, lieu_naissance, profession, nationalite, contact)
             VALUES (:nom, :firstName, :lastName, :adresse, :date_naissance, :lieu_naissance, :profession, :nationalite, :contact)"
        );
        $stmt->execute($dataPere);
        $id_pere = $pdo->lastInsertId();
    
        // 3. Enregistrer l'hôpital
        $stmt = $pdo->prepare(
            "INSERT INTO hopital (nom, ville,adresse)
             VALUES (:nom, :ville, :adresse)"
        );
        $stmt->execute($dataHopital);
        $id_hopital = $pdo->lastInsertId();
    
        // 4. Enregistrer le médecin
        $stmt = $pdo->prepare(
            "INSERT INTO medecin (nom, firstName, specialisation, contact)
             VALUES (:nom, :firstName, :specialisation, :contact)"
        );
        $stmt->execute($dataMedecin);
        $id_medecin = $pdo->lastInsertId();
    
        // 5. Enregistrer la naissance
        $dataNaissance = array_merge($dataNaissance, [
            'mere_id' => $id_mere,
            'pere_id' => $id_pere,
            'hopital_id' => $id_hopital,
            'medecin_id' => $id_medecin
        ]);
        $stmt = $pdo->prepare(
            "INSERT INTO naissance (dateNaissance, heure, lieu_naissance, mere_id, pere_id, hopital_id, medecin_id)
             VALUES (:dateNaissance, :heure, :lieu_naissance, :mere_id, :pere_id, :hopital_id, :medecin_id)"
        );
        $stmt->execute($dataNaissance);
        $id_naissance = $pdo->lastInsertId();

        // 7. Enregistrer l'acte de naissance
        $dataActNaissance = array_merge($dataActNaissance, [
            'naissance_id' => $id_naissance
        ]);
        $stmt = $pdo->prepare(
            "INSERT INTO acte_naissance (numero_acte, naissance_id)
             VALUES (:numero_acte, :naissance_id)"
        );
        $stmt->execute($dataActNaissance);
        $id_acteNaissance = $pdo->lastInsertId();
    
        // 6. Enregistrer l'enfant et lier à la naissance
        $dataEnfant = array_merge($dataEnfant, [
            'mere_id' => $id_mere,
            'pere_id' => $id_pere,
            'naissance_id' => $id_naissance,
            'acte_naissance_id' => $id_acteNaissance,
            'medecin_id' => $id_medecin,
        ]);

        $stmt = $pdo->prepare(
            "INSERT INTO enfant (nom, poids,firstName, lastName, mere_id, pere_id, 
                                        sexe,vaccin_bcg,vaccin_polio,naissance_id, acte_naissance_id, medecin_id)
             VALUES (:nom, :poids, :firstName, :lastName, :mere_id, :pere_id, :sexe,
                                         :vaccin_bcg, :vaccin_polio, :naissance_id, :acte_naissance_id, :medecin_id)"
        );
        $stmt->execute($dataEnfant);
    
        // Valider la transaction
        return $pdo->commit();
    
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Erreur lors de l'enregistrement des données : " . $e->getMessage();
    }
}

function getAllEnfants() {
    try {
        $pdo = db_connect();

        $stmt = $pdo->prepare("
            SELECT 
                enfant.id AS enfant_id,
                enfant.nom AS nom_enfant,
                enfant.poids AS poids_enfant,
                enfant.firstName AS postnom_enfant,
                enfant.lastName As prenom_enfant,
                enfant.sexe AS sexe_enfant,
                enfant.date_enregistrement AS date_enregistrement,
                
                mere.nom AS nom_mere,
                mere.firstName AS prenom_mere,
                
                pere.nom AS nom_pere,
                pere.firstName AS prenom_pere,
                
                naissance.dateNaissance AS date_naissance_enfant,
                naissance.lieu_naissance AS lieu_naissance_enfant,

                acte_naissance.numero_acte AS numero_acteNaissance,

                medecin.nom AS nom_medecin,
                medecin.firstName AS postnom_medecin,
                medecin.contact AS contact_medecin,
                medecin.specialisation AS specialisation

            FROM 
                enfant
            JOIN 
                mere ON enfant.mere_id = mere.id
            JOIN 
                pere ON enfant.pere_id = pere.id
            JOIN 
                naissance ON enfant.naissance_id = naissance.id
            JOIN
                acte_naissance ON enfant.acte_naissance_id = acte_naissance.id
            JOIN
                medecin ON enfant.medecin_id = medecin.id
        ");

        // Exécute la requête
        $stmt->execute();
        
        // Récupère tous les résultats sous forme de tableau associatif
        $enfants = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $enfants;

    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}


function getEnfantDetails($enfantId) {
    try {
        $pdo = db_connect();

        $stmt = $pdo->prepare("
            SELECT 
                enfant.id AS enfant_id,
                enfant.nom AS nom_enfant,
                enfant.poids AS poids_enfant,
                enfant.firstName AS postnom_enfant,
                enfant.lastName AS prenom_enfant,
                enfant.sexe AS sexe_enfant,
                
                mere.nom AS nom_mere,
                mere.firstName AS postnom_mere,
                mere.lastName AS prenom_mere,
                mere.contact AS contact_mere,
                mere.date_naissance AS date_naissance_mere,
                mere.lieu_naissance AS lieu_naissance_mere,
                mere.profession AS profession_mere,
                mere.nationalite AS nationalite_mere,
                mere.adresse AS adresse_mere,
                
                pere.nom AS nom_pere,
                pere.firstName AS postnom_pere,
                pere.lastName AS prenom_pere,
                pere.contact AS contact_pere,
                pere.date_naissance AS date_naissance_pere,
                pere.lieu_naissance AS lieu_naissance_pere,
                pere.profession AS profession_pere,
                pere.nationalite AS nationalite_pere,
                pere.adresse AS adresse_pere,
                
                naissance.dateNaissance AS date_naissance_enfant,
                naissance.heure AS heure_naissance_enfant,
                naissance.lieu_naissance AS lieu_naissance_enfant,

                medecin.nom AS nom_medecin,
                medecin.firstName AS postnom_medecin,
                medecin.contact AS contact_medecin,
                medecin.specialisation AS specialisation
                
            FROM 
                enfant
            JOIN 
                mere ON enfant.mere_id = mere.id
            JOIN 
                pere ON enfant.pere_id = pere.id
            JOIN 
                naissance ON enfant.naissance_id = naissance.id
            JOIN
                medecin ON enfant.medecin_id = medecin.id
            WHERE 
                enfant.id = :enfant_id
        ");

        // Exécute la requête en passant l'ID de l'enfant
        $stmt->execute(['enfant_id' => $enfantId]);
        
        // Récupère les résultats sous forme de tableau associatif
        $enfantDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $enfantDetails;

    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}


function updateEnfant($id, $dataEnfant, $dataMere, $dataPere, $dataNaissance, $dataMedecin) {
    try {
        $pdo = db_connect();

        // Démarrer une transaction
        $pdo->beginTransaction();

        // 1. Mise à jour de l'enfant
        $sqlEnfant = "UPDATE enfant SET nom = :nom, firstName = :firstName, lastName = :lastName, poids= :poids ,sexe = :sexe WHERE id = :id";
        $stmtEnfant = $pdo->prepare($sqlEnfant);
        $stmtEnfant->execute([
            ':id' => $id,
            ':nom' => $dataEnfant['nom'],
            ':sexe' => $dataEnfant['sexe'],
            ':poids' => $dataEnfant['poids'],
            ':lastName' => $dataEnfant['lastName'],
            ':firstName' => $dataEnfant['firstName'],
        ]);

        // 2. Mise à jour de la mère
        if (!empty($dataMere)) {
            $sqlMere = "UPDATE mere SET nom = :nom, firstName = :firstName, lastName = :lastName, adresse = :adresse, date_naissance = :date_naissance, lieu_naissance = :lieu_naissance, profession = :profession, nationalite = :nationalite, contact = :contact WHERE id = :mere_id";
            $stmtMere = $pdo->prepare($sqlMere);
            $stmtMere->execute([
                ':nom' => $dataMere['nom'],
                ':adresse' => $dataMere['adresse'],
                ':contact' => $dataMere['contact'],
                ':lastName' => $dataMere['lastName'],
                ':mere_id' => $dataEnfant['mere_id'],
                ':firstName' => $dataMere['firstName'],
                ':profession' => $dataMere['profession'],
                ':nationalite' => $dataMere['nationalite'],
                ':date_naissance' => $dataMere['date_naissance'],
                ':lieu_naissance' => $dataMere['lieu_naissance'],
            ]);
        }

        // 3. Mise à jour du père
        if (!empty($dataPere)) {
            $sqlPere = "UPDATE pere SET nom = :nom, firstName = :firstName, lastName = :lastName, adresse = :adresse, date_naissance = :date_naissance, lieu_naissance = :lieu_naissance, profession = :profession, nationalite = :nationalite, contact = :contact WHERE id = :pere_id";
            $stmtPere = $pdo->prepare($sqlPere);
            $stmtPere->execute([
                ':nom' => $dataPere['nom'],
                ':adresse' => $dataPere['adresse'],
                ':contact' => $dataPere['contact'],
                ':lastName' => $dataPere['lastName'],
                ':pere_id' => $dataEnfant['pere_id'],
                ':firstName' => $dataPere['firstName'],
                ':profession' => $dataPere['profession'],
                ':nationalite' => $dataPere['nationalite'],
                ':date_naissance' => $dataPere['date_naissance'],
                ':lieu_naissance' => $dataPere['lieu_naissance'],
            ]);
        }

        // 4. Mise à jour des informations de naissance
        if (!empty($dataNaissance)) {
            $sqlNaissance = "UPDATE naissance SET dateNaissance = :dateNaissance, heure = :heure, lieu_naissance = :lieu_naissance WHERE id = :naissance_id";
            $stmtNaissance = $pdo->prepare($sqlNaissance);
            $stmtNaissance->execute([
                ':heure' => $dataNaissance['heure'],
                ':naissance_id' => $dataEnfant['naissance_id'],
                ':dateNaissance' => $dataNaissance['dateNaissance'],
                ':lieu_naissance' => $dataNaissance['lieu_naissance'],
            ]);
        }

        // 5. Mise à jour des informations de medecin
        if (empty($dataMedecin))
        {
            $sqlMedecin = "UPDATE medecin SET nom = :nom, firstName = :firstName, contact = :contact, specialisation = :specialisation WHERE id = :medecin_id";
            $stmMedecin = $pdo->prepare($sqlMedecin);
            $stmMedecin->execute([
                ':nom' => $dataMedecin['nom'],
                ':contact' => $dataMedecin['contact'],
                'medecin_id' => $dataEnfant['medecin_id'],
                ':firstName' => $dataMedecin['postnom_medecin'],
                ':specialisation' => $dataMedecin['specialisation'],
            ]);
        }

        // Valider la transaction
        
        if ($pdo->commit()) {
            header("Location: listCertificat.php");
        exit();
         } else {
            return "Erreur lors de la modification.";
        }

    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        return "Erreur lors de la mise à jour des informations : " . $e->getMessage();
    }
}

function searchEnfant($nom, $dateNaissance) {

    if (!empty($nom) || !empty($dataNaissance))
    {
        try {
            $pdo = db_connect();
    
            // Définir la base de la requête SQL
            $sql = "
                SELECT 
                    enfant.id AS enfant_id,
                    enfant.nom AS nom_enfant,
                    enfant.firstName AS postnom_enfant,
                    enfant.lastName AS prenom_enfant,
                    enfant.date_enregistrement AS date_enregistrement,
                    
                    mere.nom AS nom_mere,
                    pere.nom AS nom_pere,
                    naissance.dateNaissance AS date_naissance_enfant
                    
                FROM enfant
                JOIN mere ON enfant.mere_id = mere.id
                JOIN pere ON enfant.pere_id = pere.id
                JOIN naissance ON enfant.naissance_id = naissance.id
                WHERE 1 = 1
            ";
    
            // Préparer un tableau pour les paramètres de la requête
            $params = [];
    
            // Ajouter les conditions en fonction des critères de recherche
            if (!empty($nom)) {
                $sql .= " AND (enfant.nom LIKE :nom OR enfant.firstName LIKE :nom OR enfant.lastName LIKE :nom)";
                $params[':nom'] = '%' . $nom . '%';
            }
    
            if (!empty($dateNaissance)) {
                $sql .= " AND naissance.dateNaissance = :dateNaissance";
                $params[':dateNaissance'] = $dateNaissance;
            }
    
            // Préparer et exécuter la requête
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
    
            // Récupérer les résultats sous forme de tableau associatif
            $enfants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $enfants;
    
        } catch (Exception $e) {
            echo "Erreur lors de la recherche de l'enfant : " . $e->getMessage();
            return false;
        }
    }
    else {

        //header("Location: searchEnfant.php");
    }
}


function deleteEnfant($enfantId, &$message) {
    try {
        $pdo = db_connect();

        // Démarrer une transaction
        $pdo->beginTransaction();

        // 1. Récupérer les IDs associés pour la mère, le père, la naissance et l'acte de naissance
        $stmt = $pdo->prepare("
            SELECT mere_id, pere_id, naissance_id, acte_naissance_id 
            FROM enfant 
            WHERE id = :enfant_id
        ");
        $stmt->execute([':enfant_id' => $enfantId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new Exception("Enfant non trouvé.");
        }

        $mereId = $result['mere_id'];
        $pereId = $result['pere_id'];
        $naissanceId = $result['naissance_id'];
        $acteNaissanceId = $result['acte_naissance_id'];

        // 2. Supprimer l'acte de naissance
        $stmt = $pdo->prepare("DELETE FROM acte_naissance WHERE id = :acte_id");
        $stmt->execute([':acte_id' => $acteNaissanceId]);

        // 3. Supprimer la naissance
        $stmt = $pdo->prepare("DELETE FROM naissance WHERE id = :naissance_id");
        $stmt->execute([':naissance_id' => $naissanceId]);

        // 4. Supprimer les informations de la mère et du père
        $stmt = $pdo->prepare("DELETE FROM mere WHERE id = :mere_id");
        $stmt->execute([':mere_id' => $mereId]);

        $stmt = $pdo->prepare("DELETE FROM pere WHERE id = :pere_id");
        $stmt->execute([':pere_id' => $pereId]);

        // 5. Supprimer l'enfant
        $stmt = $pdo->prepare("DELETE FROM enfant WHERE id = :enfant_id");
        $stmt->execute([':enfant_id' => $enfantId]);

        // Valider la transaction
        if ($pdo->commit()) {
            // Si la suppression réussit, redirection vers la page d'accueil
            header("Location: listCertificat.php");
            exit(); // Terminer l'exécution du script après la redirection
        } else {
            // Si la suppression échoue, on modifie le message d'erreur
            $message = "Erreur lors de la suppression.";
        }
    
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        return "Erreur lors de la suppression de l'enfant : " . $e->getMessage();
    }
}

?>