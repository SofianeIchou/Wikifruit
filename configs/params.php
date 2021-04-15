<?php

// Récupération de la route actuelle dans l'URL
define('ROUTE', request_path());

// Emplacement du dossier qui contient les vues
define('VIEWS_DIR', __DIR__ . '/../views/');

// URL du dossier publique (avec fichiers CSS, JS, etc...), servira pour construire les liens dans la partie front-end
define('PUBLIC_PATH', mb_substr($_SERVER['SCRIPT_NAME'], 0, -(mb_strlen(basename(__FILE__)))) . '/');

// Paramètres de connexion à la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'wikifruit_mvc_poo');
define('DB_USER', 'root');
define('DB_PASSWORD', '');