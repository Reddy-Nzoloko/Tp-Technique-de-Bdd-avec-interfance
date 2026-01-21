<?php
class HospitalModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Suppression d'un site
public function deleteSite($id) {
    $query = "DELETE FROM Site WHERE idSite = :id";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([':id' => $id]);
}

// Nouvelle méthode utilisant la VUE SQL
public function getAllDataFromView() {
    $query = "SELECT * FROM vue_structure_complete ORDER BY nomOrganisation, nomSite, nomService";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function createOrganisation($nom) {
        try {
            $query = "INSERT INTO Organisation (nomOrganisation) VALUES (:nom)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([':nom' => $nom]);
        } catch (PDOException $e) {
            error_log("Erreur SQL Organisation: " . $e->getMessage());
            return false;
        }
    }

    public function createService($nom, $idSite, $prefixe) {
        try {
            $query = "INSERT INTO Service (nomService, idSite, codePrefixe) VALUES (:nom, :idSite, :prefixe)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                ':nom' => $nom,
                ':idSite' => $idSite,
                ':prefixe' => $prefixe
            ]);
        } catch (PDOException $e) {
            error_log("Erreur SQL Service: " . $e->getMessage());
            return false;
        }
    }

    public function getListSites() {
        $query = "SELECT idSite, nomSite FROM Site";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Dans HospitalModel.php, ajoutez :

public function createSite($nom, $idOrganisation) {
    try {
        $query = "INSERT INTO Site (nomSite, idOrganisation) VALUES (:nom, :idOrg)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':nom' => $nom, 
            ':idOrg' => $idOrganisation
        ]);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}
// fonction suppresion d'un service 

public function deleteService($id) {
    $query = "DELETE FROM Service WHERE idService = :id";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([':id' => $id]);
}

public function getListOrganisations() {
    $query = "SELECT idOrganisation, nomOrganisation FROM Organisation";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Dans HospitalModel.php

public function deleteOrganisation($id) {
    try {
        $query = "DELETE FROM Organisation WHERE idOrganisation = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        error_log("Erreur suppression : " . $e->getMessage());
        return false;
    }
}
}