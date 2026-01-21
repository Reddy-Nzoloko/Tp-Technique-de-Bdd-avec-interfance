<?php
/**
 * INDEX.PHP - Point d'entrée unique de l'application (Routeur)
 */

// 1. Affichage des erreurs (très utile pendant le développement)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Importation des fichiers nécessaires pour notre index 
// Assurez-vous que les noms de dossiers et de fichiers sont exactement les mêmes
require_once 'config/database.php';
require_once 'models/HospitalModel.php';
require_once 'controllers/HospitalController.php';

// 3. Initialisation du contrôleur
// C'est lui qui va décider si on affiche la page ou si on traite un formulaire
$app = new HospitalController();

// 4. Lancement de l'application
// Cette méthode gère à la fois l'affichage (GET) et les ajouts en BDD (POST)
$app->handleRequest();