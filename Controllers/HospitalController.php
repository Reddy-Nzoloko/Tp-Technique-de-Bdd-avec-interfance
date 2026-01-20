<?php
require_once 'config/database.php';
require_once 'models/HospitalModel.php';

class HospitalController {
    public function showDashboard() {
        // 1. Connexion BDD
        $database = new Database();
        $db = $database->getConnection();

        // 2. Récupérer les données
        $model = new HospitalModel($db);
        $data = $model->getHierarchy();

        // 3. Envoyer à la vue
        require_once 'views/dashboard.php';
    }
}