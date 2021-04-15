<?php

use App\Controllers\MainController;

// On instancie le controller général qui contient les contrôleurs de toutes les pages du site
$mainController = new MainController();


// Liste des routes avec leur contrôleur
// Chaque url correspond à une nouvelle page du site
// default est la page par défaut si l'url demandé ne correspond à aucune page (la page 404)
switch(ROUTE){

    // Route de la page d'accueil
    case '/';
        $mainController->home();
    break;

    // Route de la page d'inscription
    case '/creer-un-compte/';
        $mainController->register();
    break;

    // Route de la page de connexion
    case '/connexion/';
        $mainController->login();
    break;

    // Route de la page de déconnexion
    case '/deconnexion/';
        $mainController->logout();
    break;

    // Route de la page qui liste les fruits
    case '/fruits/liste/';
        $mainController->fruitsList();
    break;

    // Route de la page quia ffiche un fruit en détail
    case '/fruits/fiche/';
        $mainController->fruitDetails();
    break;

    // Route de la page qui permet d'ajouter un nouveau fruit
    case '/fruits/ajouter-un-fruit/';
        $mainController->addNewFruit();
    break;

    // Route de la page qui permet de modifier un fruit existant
    case '/fruits/modifier/';
        $mainController->editFruit();
    break;

    // Route de la page qui permet de supprimer un fruit existant
    case '/fruits/supprimer/';
        $mainController->deleteFruit();
    break;

    // Si aucune des URL précédents ne match, c'est la page 404 qui sera appelée par défaut
    default:
        $mainController->page404();
    break;

}