<?php
require_once 'config/database.php';
require_once 'models/HospitalModel.php';

class HospitalController {
    public function handleRequest() {
        $database = new Database();
        $db = $database->getConnection();
        $model = new HospitalModel($db);

        // 1. GESTION DES ENREGISTREMENTS (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'addOrg':
                    if (!empty($_POST['nomOrganisation'])) {
                        $model->createOrganisation($_POST['nomOrganisation']);
                    }
                    break;
                case 'addSite':
                    if (!empty($_POST['nomSite']) && !empty($_POST['idOrganisation'])) {
                        $model->createSite($_POST['nomSite'], $_POST['idOrganisation']);
                    }
                    break;
                case 'addService':
                    if (!empty($_POST['nomService']) && !empty($_POST['idSite'])) {
                        $model->createService($_POST['nomService'], $_POST['idSite'], $_POST['codePrefixe']);
                    }
                    break;
            }
            header("Location: index.php");
            exit();
        }

        // 2. RÉCUPÉRATION DES DONNÉES POUR LA VUE
        $allOrgs = $model->getListOrganisations(); 
        $allSites = $model->getListSites();        
        $rawData = $model->getAllData();
        
        // Structuration hiérarchique : Org > Site > Service
        $organisations = [];
        foreach ($rawData as $row) {
            $orgId = $row['idOrganisation'];
            $siteId = $row['idSite'];

            if (!isset($organisations[$orgId])) {
                $organisations[$orgId] = [
                    'nom' => $row['nomOrganisation'],
                    'sites' => []
                ];
            }

            if ($siteId && !isset($organisations[$orgId]['sites'][$siteId])) {
                $organisations[$orgId]['sites'][$siteId] = [
                    'nom' => $row['nomSite'],
                    'services' => []
                ];
            }

            if ($row['idService']) {
                $organisations[$orgId]['sites'][$siteId]['services'][] = [
                    'nom' => $row['nomService'],
                    'code' => $row['codePrefixe']
                ];
            }
        }

        require_once 'views/dashboard.php';
    }
}