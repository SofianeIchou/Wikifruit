<?php

namespace App\Controllers;

use App\Models\DAO\FruitManager;
use App\Models\DAO\UserManager;
use App\Models\DTO\Fruit;
use App\Models\DTO\User;
use \DateTime;

class MainController{

    /**
     * Contrôleur de la page d'accueil
     */
    public function home()
    {

        // Charge la vue home.php dans le dossier "views"
        include VIEWS_DIR . 'home.php';
    }


    /**
     * Contrôleur de la page d'inscription
     */
    public function register(){

        // Redirige de force sur la page d'accueil si l'utilisateur est déjà connecté
        if(isConnected()){
            header('Location: ' . PUBLIC_PATH);
            die;
        }

        // Appel des variables
        if(
            isset($_POST['email']) &&
            isset($_POST['password']) &&
            isset($_POST['confirm-password']) &&
            isset($_POST['firstname']) &&
            isset($_POST['lastname'])
        ){

            // Bloc des verif
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Email invalide !';
            }

            if(!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[ !"#\$%&\'()*+,\-.\/:;<=>?@[\\\\\]\^_`{\|}~]).{8,4096}$/', $_POST['password'])){
                $errors['password'] = 'Le mot de passe doit contenir au moins 8 caractères dont 1 minuscule, 1 majuscule, 1 chiffre et une lettre !';
            }

            if($_POST['password'] != $_POST['confirm-password']){
                $errors['confirm-password'] = 'La confirmation du mot de passe ne correspond pas au mot de passe !';
            }

            if(mb_strlen($_POST['firstname']) < 1 || mb_strlen($_POST['firstname']) > 50){
                $errors['firstname'] = 'Le prénom doit faire entre 2 et 50 caractères !';
            }

            if(mb_strlen($_POST['lastname']) < 1 || mb_strlen($_POST['lastname']) > 50){
                $errors['lastname'] = 'Le nom doit faire entre 2 et 50 caractères !';
            }

            // Si pas d'erreurs
            if(!isset($errors)){

                // Récupération du manager des utilisateurs
                $userManager = new UserManager();

                // Récupération via le manager du compte ayant l'email envoyé par le formulaire (vérification si l'email est déjà prise ou pas)
                $checkUser = $userManager->findOneBy('email', $_POST['email']);

                // Si l'utilisateur existe déjà, erreur
                if(!empty($checkUser)){
                    $errors['email'] = 'Cette adresse email est déjà utilisée !';
                } else {

                    // Création d'un nouvel utilisateur
                    $newAccount = new User();

                    // Hydratation du nouvel utilisateur
                    $newAccount
                        ->setEmail($_POST['email'])
                        ->setPassword(password_hash($_POST['password'], PASSWORD_BCRYPT))   // On stocke évidemment l'empreinte BCRYPT du mot de passe !
                        ->setFirstname($_POST['firstname'])
                        ->setLastname($_POST['lastname'])
                        ->setRegisterDate(new DateTime())   // On stocke la date actuelle sous la forme d'un objet de la classe DateTime
                    ;

                    // Sauvegarde en BDD du nouvel utilisateur
                    $statut = $userManager->save($newAccount);

                    // Vérification du booléen de réusite/échec
                    if($statut){
                        $success = 'Votre compte a bien été créé !';
                    } else {
                        $errors['server'] = 'Problème avec la base de données, veuillez ré-essayer plus tard !';
                    }

                }

            }

        }

        // Charge la vue register.php dans le dossier "views"
        include VIEWS_DIR . 'register.php';
    }


    /**
     * Contrôleur de la page de connexion
     */
    public function login()
    {

        // Redirige de force sur la page d'accueil si l'utilisateur est déjà connecté
        if(isConnected()){
            header('Location: ' . PUBLIC_PATH);
            die;
        }

        // Appel des variables
        if(
            isset($_POST['email']) &&
            isset($_POST['password'])
        ){

            // Bloc des verif
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Email invalide !';
            }

            if(!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[ !"#\$%&\'()*+,\-.\/:;<=>?@[\\\\\]\^_`{\|}~]).{8,4096}$/', $_POST['password'])){
                $errors['password'] = 'Le mot de passe n\'est pas écrit correctement !';
            }

            // Si pas d'erreurs
            if(!isset($errors)){


                // Récupération du manager des utilisateurs
                $userManager = new UserManager();

                // Récupération de l'utilisateur via son email
                $userToConnect = $userManager->findOneBy('email', $_POST['email']);

                // Si l'utilisateur n'a pas été trouvé, erreur
                if(empty($userToConnect)){
                    $errors['email'] = 'Ce compte n\'existe pas !';
                } else {

                    // Si le mot de passe n'est pas bon par rapport à l'empreinte BCRYPT stockée en BDD, erreur
                    if(!password_verify($_POST['password'], $userToConnect->getPassword())){
                        $errors['password'] = 'Le mot de passe est invalide !';
                    } else {

                        // Stockage de l'objet de l'utilisateur connecté en session
                        $_SESSION['user'] = $userToConnect;
                        $success = 'Connexion réussi !';

                    }

                }

            }

        }

        // Charge la vue login.php dans le dossier "views"
        include VIEWS_DIR . 'login.php';
    }


    /**
     * Contrôleur de la page de déconnexion
     */
    public function logout(){

        // Redirige de force sur la page d'accueil si l'utilisateur n'est pas connecté
        if(!isConnected()){
            header('Location: ' . PUBLIC_PATH);
            die;
        }

        // Destruction de l'utilisateur en session (ça le déconnecte)
        unset($_SESSION['user']);

        // Charge la vue logout.php dans le dossier "views"
        include VIEWS_DIR . 'logout.php';

    }


    /**
     * Contrôleur de la page qui liste tous les fruits
     */
    public function fruitsList()
    {

        // Récupération du manager des fruits
        $fruitManager = new FruitManager();

        // Récupération de la liste complète de tous les fruits via le manager
        $fruitsList = $fruitManager->findAll();

        // Charge la vue fruitsList.php dans le dossier "views"
        include VIEWS_DIR . 'fruitsList.php';
    }


    /**
     * Contrôleur de la page qui affiche en détail un fruit
     */
    public function fruitDetails()
    {

        // Si $_GET['id'] n'existe pas ou n'est pas un id valide (entier entre 1 et 99999999999), chargement de la page 404
        if(!isset($_GET['id']) || !preg_match('/^[1-9][0-9]{0,10}$/', $_GET['id'])){
            $this->page404();
            die;
        }

        // Récupération du manager des fruits
        $fruitManager = new FruitManager();

        // Récupération du fruit en BDD via son id
        $fruit = $fruitManager->findOneBy('id', $_GET['id']);

        // Si aucun fruit n'est trouvé, soit il n'existe pas, soit il n'existe plus : donc on affiche la page d'erreur 404
        if(empty($fruit)){
            $this->page404();
            die;
        }

        // Charge la vue fruitDetails.php dans le dossier "views"
        include VIEWS_DIR . 'fruitDetails.php';
    }


    /**
     * Contrôleur de la page permettant d'ajouter un nouveau fruit
     */
    public function addNewFruit()
    {

        // Redirige de force sur la page d'accueil si l'utilisateur n'est pas connecté
        if(!isConnected()){
            header('Location: ' . PUBLIC_PATH);
            die;
        }

        // Appel des variables
        if(
            isset($_POST['name']) &&
            isset($_POST['color']) &&
            isset($_POST['origin']) &&
            isset($_POST['price-per-kilo']) &&
            isset($_POST['description'])
        ){

            // Bloc des verifs
            if(mb_strlen($_POST['name']) < 1 || mb_strlen($_POST['name']) > 50){
                $errors['name'] = 'Le nom doit contenir entre 1 et 50 caractères !';
            }

            if(mb_strlen($_POST['color']) < 1 || mb_strlen($_POST['color']) > 50){
                $errors['color'] = 'La couleur doit contenir entre 1 et 50 caractères !';
            }

            if(mb_strlen($_POST['origin']) < 1 || mb_strlen($_POST['origin']) > 50){
                $errors['origin'] = 'Le pays d\'origine doit contenir entre 1 et 50 caractères !';
            }

            if(!preg_match('/^[0-9]{1,7}([.,][0-9]{1,2})?$/', $_POST['price-per-kilo'])){
                $errors['price-per-kilo'] = 'Le prix doit être compris entre 0 et 9999999,99 !';
            }

            if(mb_strlen($_POST['description']) < 10 || mb_strlen($_POST['description']) > 20000){
                $errors['description'] = 'La description doit contenir entre 10 et 20 000 caractères !';
            }

            // Si pas d'erreurs
            if(!isset($errors)){

                // Création d'un nouveau fruit
                $newFruit = new Fruit();

                // Hydratation du nouveau fruit
                $newFruit
                    ->setName($_POST['name'])
                    ->setColor($_POST['color'])
                    ->setOrigin($_POST['origin'])
                    ->setPricePerKilo( str_replace(',', '.', $_POST['price-per-kilo']) )
                    ->setUser( $_SESSION['user'] )
                    ->setDescription($_POST['description'])
                ;

                // Récupération du manager des fruits
                $fruitManager = new FruitManager();

                // Création du nouveau fruit en bdd
                $statut = $fruitManager->save($newFruit);

                // Vérification du booléen de réussite/échec
                if($statut){
                    $success = 'Le fruit a bien été ajouté !';
                } else {
                    $errors['server'] = 'Problème avec la base de données, veuillez ré-essayer plus tard !';
                }

            }

        }

        // Charge la vue addNewFruit.php dans le dossier "views"
        include VIEWS_DIR . 'addNewFruit.php';
    }

    /**
     * Contrôleur de la page qui permet de modifier un fruit existant
     */
    public function editFruit()
    {

        // Redirige de force sur la page d'accueil si l'utilisateur n'est pas connecté
        if(!isConnected()){
            header('Location: ' . PUBLIC_PATH);
            die;
        }

        // Si $_GET['id'] n'existe pas ou n'est pas un id valide (entier entre 1 et 99999999999), chargement de la page 404
        if(!isset($_GET['id']) || !preg_match('/^[1-9][0-9]{0,10}$/', $_GET['id'])){
            $this->page404();
            die;
        }

        // Récupération du manager des fruits
        $fruitManager = new FruitManager();

        // Récupération du fruit en BDD via son id
        $fruitToUpdate = $fruitManager->findOneBy('id', $_GET['id']);


        // Si aucun fruit n'est trouvé, soit il n'existe pas, soit il n'existe plus : donc on affiche la page d'erreur 404
        if(empty($fruitToUpdate)){
            $this->page404();
            die;
        }

        // Appel des variables
        if(
            isset($_POST['name']) &&
            isset($_POST['color']) &&
            isset($_POST['origin']) &&
            isset($_POST['price-per-kilo']) &&
            isset($_POST['description'])
        ) {

            // Bloc des verifs
            if (mb_strlen($_POST['name']) < 1 || mb_strlen($_POST['name']) > 50) {
                $errors['name'] = 'Le nom doit contenir entre 1 et 50 caractères !';
            }

            if (mb_strlen($_POST['color']) < 1 || mb_strlen($_POST['color']) > 50) {
                $errors['color'] = 'La couleur doit contenir entre 1 et 50 caractères !';
            }

            if (mb_strlen($_POST['origin']) < 1 || mb_strlen($_POST['origin']) > 50) {
                $errors['origin'] = 'Le pays d\'origine doit contenir entre 1 et 50 caractères !';
            }

            if (!preg_match('/^[0-9]{1,7}([.,][0-9]{1,2})?$/', $_POST['price-per-kilo'])) {
                $errors['price-per-kilo'] = 'Le prix doit être compris entre 0 et 9999999,99 !';
            }

            if (mb_strlen($_POST['description']) < 10 || mb_strlen($_POST['description']) > 20000) {
                $errors['description'] = 'La description doit contenir entre 10 et 20 000 caractères !';
            }

            // Si pas d'erreurs
            if (!isset($errors)) {

                // Ré-hydratation du fruit avec les nouvelles données venant du formulaire
                $fruitToUpdate
                    ->setName($_POST['name'])
                    ->setColor($_POST['color'])
                    ->setOrigin($_POST['origin'])
                    ->setPricePerKilo(str_replace(',', '.', $_POST['price-per-kilo']))
                    ->setUser($_SESSION['user'])
                    ->setDescription($_POST['description'])
                ;

                // Mise à jour en BDD du fruit
                $statut = $fruitManager->save($fruitToUpdate);

                // Vérification du booléen de réussite/échec
                if ($statut) {
                    $success = 'Le fruit a bien été modifié !';
                } else {
                    $errors['server'] = 'Problème avec la base de données, veuillez ré-essayer plus tard !';
                }

            }
        }

        // Charge la vue editFruit.php dans le dossier "views"
        include VIEWS_DIR . 'editFruit.php';
    }


    /**
     * Contrôleur de la page qui permet de supprimer un fruit
     */
    public function deleteFruit(){

        // Redirige de force sur la page d'accueil si l'utilisateur n'est pas connecté
        if(!isConnected()){
            header('Location: ' . PUBLIC_PATH);
            die;
        }

        // Si $_GET['id'] n'existe pas ou n'est pas un id valide (entier entre 1 et 99999999999), chargement de la page 404
        if(!isset($_GET['id']) || !preg_match('/^[1-9][0-9]{0,10}$/', $_GET['id'])){
            $this->page404();
            die;
        }

        // Récupération du manager des fruits
        $fruitManager = new FruitManager();

        // Récupération du fruit en BDD via son id
        $fruitToDelete = $fruitManager->findOneBy('id', $_GET['id']);

        // Si aucun fruit n'est trouvé, soit il n'existe pas, soit il n'existe plus : donc on affiche la page d'erreur 404
        if(empty($fruitToDelete)){
            $this->page404();
            die;
        }

        // Suppression du fruit en BDD
        $fruitManager->delete($fruitToDelete);

        // Charge la vue deleteFruit.php dans le dossier "views"
        include VIEWS_DIR . 'deleteFruit.php';
    }


    /**
     * Contrôleur de la page 404
     */
    public function page404()
    {
        // Modifie le HTTP code pour qu'il soit bien 404 et non 200
        header("HTTP/1.0 404 Not Found");

        // Charge la vue 404.php dans le dossier "views"
        include VIEWS_DIR . '404.php';
    }

}