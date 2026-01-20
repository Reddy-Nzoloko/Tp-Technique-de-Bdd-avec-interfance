<?php
require_once 'config/database.php';
require_once 'models/HospitalModel.php';

class HospitalController {
    public function handleRequest() {
        // Initialisation de la connexion et du modèle
        $database = new Database();
        $db = $database->getConnection();
        $model = new HospitalModel($db);

        // --- 1. GESTION DES ACTIONS (POST) ---
        // On intercepte les formulaires envoyés avant de charger les données
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            switch ($_POST['action']) {
                
                case 'addOrg': // Ajouter une organisation
                    if (!empty($_POST['nomOrganisation'])) {
                        $model->createOrganisation($_POST['nomOrganisation']);
                    }
                    break;

                case 'addSite': // Ajouter un site à une organisation
                    if (!empty($_POST['nomSite']) && !empty($_POST['idOrganisation'])) {
                        $model->createSite($_POST['nomSite'], $_POST['idOrganisation']);
                    }
                    break;

                case 'addService': // Ajouter un service à un site
                    if (!empty($_POST['nomService']) && !empty($_POST['idSite'])) {
                        $model->createService($_POST['nomService'], $_POST['idSite'], $_POST['codePrefixe']);
                    }
                    break;

                case 'deleteOrg': // Supprimer une organisation (et ses enfants via Cascade)
                    if (!empty($_POST['idOrganisation'])) {
                        $model->deleteOrganisation($_POST['idOrganisation']);
                    }
                    break;

                case 'deleteSite': // Supprimer un site spécifique
                    if (!empty($_POST['idSite'])) {
                        $model->deleteSite($_POST['idSite']);
                    }
                    break;
            }
            
            // Redirection pour éviter de renvoyer le formulaire en actualisant la page (Pattern Post-Redirect-Get)
            header("Location: index.php");
            exit();
        }

        // --- 2. RÉCUPÉRATION DES DONNÉES ---
        
        // Utile pour remplir les listes déroulantes (Select) des modales d'ajout
        $allOrgs = $model->getListOrganisations(); 
        $allSites = $model->getListSites();        
        
        // Utilisation de la VUE SQL : Récupère les données à plat (Org + Site + Service)
        // Note: Assurez-vous d'avoir créé la vue 'vue_structure_complete' en SQL
        $rawData = $model->getAllDataFromView();
        
        // --- 3. RESTRUCTURATION DES DONNÉES (LOGIQUE MÉTIER) ---
        // On transforme les lignes SQL "plates" en un tableau hiérarchique multidimensionnel
        $organisations = [];
        
        foreach ($rawData as $row) {
            $orgId = $row['idOrganisation'];
            $siteId = $row['idSite'];
            $serviceId = $row['idService'];

            // Création de l'entrée Organisation si elle n'existe pas encore
            if (!isset($organisations[$orgId])) {
                $organisations[$orgId] = [
                    'nom' => $row['nomOrganisation'],
                    'sites' => []
                ];
            }

            // Ajout du Site à l'organisation (si la ligne SQL contient un site)
            if ($siteId && !isset($organisations[$orgId]['sites'][$siteId])) {
                $organisations[$orgId]['sites'][$siteId] = [
                    'nom' => $row['nomSite'],
                    'services' => []
                ];
            }

            // Ajout du Service au site (si la ligne SQL contient un service)
            if ($serviceId) {
                $organisations[$orgId]['sites'][$siteId]['services'][] = [
                    'nom' => $row['nomService'],
                    'code' => $row['codePrefixe']
                ];
            }
        }

        // --- 4. CHARGEMENT DE LA VUE ---
        // On transmet les variables $organisations, $allOrgs et $allSites à la page dashboard.php
        require_once 'views/dashboard.php';
    }
}