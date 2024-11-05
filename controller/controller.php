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
    
        // 6. Enregistrer l'enfant et lier à la naissance
        $dataEnfant = array_merge($dataEnfant, [
            'mere_id' => $id_mere,
            'pere_id' => $id_pere,
            'naissance_id' => $id_naissance
        ]);
        $stmt = $pdo->prepare(
            "INSERT INTO enfant (nom, poids,firstName, lastName, mere_id, pere_id, sexe,vaccin_bcg,vaccin_polio,naissance_id)
             VALUES (:nom, :poids, :firstName, :lastName, :mere_id, :pere_id, :sexe, :vaccin_bcg, :vaccin_polio, :naissance_id)"
        );
        $stmt->execute($dataEnfant);

        // 7. Enregistrer l'acte de naissance
        $dataActNaissance = array_merge($dataActNaissance, [
            'naissance_id' => $id_naissance
        ]);
        $stmt = $pdo->prepare(
            "INSERT INTO acte_naissance (numero_acte, naissance_id)
             VALUES (:numero_acte, :naissance_id)"
        );
        $stmt->execute($dataActNaissance);
    
        // Valider la transaction
        return $pdo->commit();
    
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Erreur lors de l'enregistrement des données : " . $e->getMessage();
    }
}

?>