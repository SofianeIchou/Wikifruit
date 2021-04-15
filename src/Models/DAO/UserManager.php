<?php

namespace App\Models\DAO;


use App\Models\DTO\User;
use \DateTime;
use \Exception;
use \PDO;

/**
 * Classe DAO servant à gérer et faire l'interface entre les utilisateurs du site et la base de données
 */
class UserManager{

    /**
     * Stockage dans cet attribut d'une instance PDO de connexion active à la base de données
     */
    private $db;

    /**
     * Getters/setters
     */
    public function getDb()
    {
        return $this->db;
    }

    public function setDb(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * On se sert du constructeur pour hydrater l'attribut $db avec une instance de connexion à la BDD (récupérée via connectDb() )
     */
    public function __construct(){

        $this->setDb( connectDb() );

    }


    /**
     * Méthode permettant de récupérer et retourner la liste complète de tous les utilisateurs dans la base de données (les utilisateurs sont retournés dans un array et sont sous forme d'objets de la classe "User")
     */
    public function findAll()
    {

        $getUsers = $this->getDb()->query('SELECT * FROM user');
        $users = $getUsers->fetchAll(PDO::FETCH_ASSOC);

        // Pour chaque utilisateur, on crée son équivalent en objet de la classe "User"
        foreach($users as $user){
            $usersInObjects[] = $this->buildDomainObject($user);
        }

        // On retourne le tableau d'objets s'il existe, sinon un tableau vide
        return $usersInObjects ?? [];

    }


    /**
     * Méthode servant à récupérer un utilisateur par un de ses champ et une valeur de ce champ (par exemple récupérer l'utilisateur dont l'email est 'a@a.a')
     */
    public function findOneBy(string $field, $value)
    {

        // Liste des champs autorisé pour la selection
        $fields = ['id', 'email', 'password', 'firstname', 'lastname', 'register_date'];

        // Si le champ demandé n'est pas autorisé, erreur
        if(!in_array($field, $fields)){
            throw new Exception('field ' . $field . ' isn\'t valid in findOneBy()');
        }

        // Récupération de l'utilisateur répondant à la demande
        $getUser = $this->getDb()->prepare('SELECT * FROM user WHERE ' . $field . ' = ?');
        $getUser->execute([$value]);
        $user = $getUser->fetch(PDO::FETCH_ASSOC);

        // Si un utilisateur a bien été trouvé, on le converti en objet de la classe "User"
        if(!empty($user)){
            $userInObject = $this->buildDomainObject($user);
        }

        // On retourne soir l'utilisateur sous forme d'objet, soit null
        return $userInObject ?? null;

    }


    /**
     * Méthode servant à 2 choses :
     * Si l'utilisateur possède déjà un id, alors il sera actualisé dans la BDD
     * Si l'utilisateur ne possède pas d'id, il sera créé dans la BDD
     */
    public function save(User $user)
    {

        // Si l'id de l'utilisateur est null, alors il faudra le créer en BDD
        if($user->getId() == null){

            $createUser = $this->getDb()->prepare('INSERT INTO user(email, password, register_date, firstname, lastname) VALUES(?,?,?,?,?)');

            // On injecte les données de l'utilisateur à créer directement depuis l'objet
            $statut = $createUser->execute([
                $user->getEmail(),
                $user->getPassword(),
                $user->getRegisterDate()->format('Y-m-d H:i:s'),    // Ici on doit envoyer la date de l'objet DateTime stocké sous forme de chaîne de texte avec format(), pas tout l'objet renvoyé par getRegisterDate()
                $user->getFirstname(),
                $user->getLastname(),
            ]);

            // Actualisation de l'id dans l'objet
            $newId = $this->getDb()->lastInsertId();
            $user->setId($newId);

            // Retour du booléen de réussite/échec
            return $statut;

        } else {

            // Mise à jour de l'utilisateur via l'id qu'il contient
            $updateUser = $this->getDb()->prepare('UPDATE user SET email = ?, password = ?, register_date = ?, firstname = ?, lastname = ? WHERE id = ?');

            // On injecte les données de l'utilisateur à créer directement depuis l'objet
            $statut = $updateUser->execute([
                $user->getEmail(),
                $user->getPassword(),
                $user->getRegisterDate()->format('Y-m-d H:i:s'),    // Ici on doit envoyer la date de l'objet DateTime stocké sous forme de chaîne de texte avec format(), pas tout l'objet renvoyé par getRegisterDate()
                $user->getFirstname(),
                $user->getLastname(),
                $user->getId(),     // Ce paramètre permet de sélectionner le bon fruit en BDD
            ]);

            // Retour du booléen de réussite/échec
            return $statut;

        }

    }


    /**
     * Méthode servant à convertir un array d'utilisateur en un objet de la classe "User"
     */
    private function buildDomainObject(array $userInfos)
    {

        // Création et hydratation de l'objet
        $user = new User();
        $user
            ->setId($userInfos['id'])
            ->setEmail($userInfos['email'])
            ->setPassword($userInfos['password'])
            ->setFirstname($userInfos['firstname'])
            ->setLastname($userInfos['lastname'])
            ->setRegisterDate(new DateTime($userInfos['register_date']))    // Ici on stocke la date sous la forme d'un objet de la classe DateTime initialisé à la bonne date grâce à la date en chaîne de texte
        ;

        // Return du fruit en version objet
        return $user;
    }


}