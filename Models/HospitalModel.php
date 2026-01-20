<?php
class HospitalModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupère toute la hiérarchie organisée
    public function getAllData() {
        $query = "SELECT 
                    o.idOrganisation, o.nomOrganisation,
                    s.idSite, s.nomSite,
                    sv.idService, sv.nomService, sv.codePrefixe
                  FROM Organisation o
                  LEFT JOIN Site s ON o.idOrganisation = s.idOrganisation
                  LEFT JOIN Service sv ON s.idSite = sv.idSite
                  ORDER BY o.nomOrganisation, s.nomSite, sv.nomService";
        
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

public function getListOrganisations() {
    $query = "SELECT idOrganisation, nomOrganisation FROM Organisation";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}