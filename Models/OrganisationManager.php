<?php
public function getFullHierarchy() {
    $sql = "SELECT o.nomOrganisation, s.nomSite, sv.nomService, sv.codePrefixe
            FROM Organisation o
            LEFT JOIN Site s ON o.idOrganisation = s.idOrganisation
            LEFT JOIN Service sv ON s.idSite = sv.idSite
            ORDER BY o.nomOrganisation, s.nomSite";
    // Exécution PDO...
}
?>