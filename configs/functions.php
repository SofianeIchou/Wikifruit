<?php

// Activation des sessions PHP sur tout le site
session_start();

// Convertion de toutes les erreurs classiques de PHP en exceptions (comme ça elles seront aussi capturées par notre trycatch général)
function exceptions_error_handler($severity, $message, $filename, $lineno) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
}
set_error_handler('exceptions_error_handler');


// Fonction permettant de récupérer la route actuelle (partie de l'URL entre l'accès physique du dossier du site et les données GET)
// si l'url est "http://monsite.fr/contactez-nous/", la route récupérée sera "/contactez-nous/"
// si l'url est "http://monsite.fr/article/test/?name=alice", la route récupérée sera "/article/test/"
function request_path()
{
    $request_uri = explode('/', ($_SERVER['REQUEST_URI']));
    $script_name = explode('/', ($_SERVER['SCRIPT_NAME']));
    $parts = array_diff_assoc($request_uri, $script_name);
    $path = implode('/', $parts);
    if (empty($path))
    {
        return '/';
    }
    $path = '/' . $path;
    if (($position = strpos($path, '?')) !== FALSE)
    {
        $path = substr($path, 0, $position);
    }
    return $path;
}

// Fonction qui instancie une connexion à la base de données et la retourne (nécessaire pour les classes Manager DAO)
function connectDb(){
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

// Fonction qui retourne true si on est connecté, sinon false
function isConnected(){
    return isset($_SESSION['user']);
}