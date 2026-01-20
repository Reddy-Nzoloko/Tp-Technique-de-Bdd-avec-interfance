<?php
class HospitalModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupère toute la structure : Organisation > Sites > Services
    public function getAllData() {
        $query = "SELECT 
                    o.idOrganisation, o.nomOrganisation,
                    s.idSite, s.nomSite,
                    sv.idService, sv.nomService, sv.codePrefixe
                  FROM Organisation o
                  LEFT JOIN Site s ON o.idOrganisation = s.idOrganisation
                  LEFT JOIN Service sv ON s.idSite = sv.idSite
                  ORDER BY o.nomOrganisation, s.nomSite";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}