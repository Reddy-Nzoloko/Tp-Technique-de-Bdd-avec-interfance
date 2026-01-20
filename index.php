<?php
// On appelle le contrôleur
require_once 'controllers/HospitalController.php';

$app = new HospitalController();
$app->showDashboard();