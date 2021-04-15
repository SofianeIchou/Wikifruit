<?php

namespace App\Models\DAO;


use App\Models\DTO\Fruit;
use \Exception;
use \PDO;

/**
 * Classe DAO servant à gérer et faire l'interface entre les fruits du site et la base de données
 */
class FruitManager{

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
     * Méthode permettant de récupérer et retourner la liste complète de tous les fruits dans la base de données (les fruits sont retournés dans un array et sont sous forme d'objets de la classe "Fruit")
     */
    public function findAll()
    {

        $getFruits = $this->getDb()->query('SELECT * FROM fruit');
        $fruits = $getFruits->fetchAll(PDO::FETCH_ASSOC);

        // Pour chaque fruit, on crée son équivalent en objet de la classe Fruit
        foreach($fruits as $fruit){
            $fruitsInObjects[] = $this->buildDomainObject($fruit);
        }

        // On retourne le tableau d'objets s'il existe, sinon un tableau vide
        return $fruitsInObjects ?? [];

    }

    /**
     * Méthode servant à récupérer un fruit par un de ses champ et une valeur de ce champ (par exemple récupérer le fruit dont l'id est 5)
     */
    public function findOneBy(string $field, $value)
    {

        // Liste des champs autorisé pour la selection
        $fields = ['id', 'name', 'color', 'origin', 'price_per_kilo', 'user_id', 'description'];

        // Si le champ demandé n'est pas autorisé, erreur
        if(!in_array($field, $fields)){
            throw new Exception('field ' . $field . ' isn\'t valid in findOneBy()');
        }

        // Récupération du fruit répondant à la demande
        $getFruit = $this->getDb()->prepare('SELECT * FROM fruit WHERE ' . $field . ' = ?');
        $getFruit->execute([$value]);
        $fruit = $getFruit->fetch(PDO::FETCH_ASSOC);


        // Si un fruit a bien été trouvé, on le converti en objet de la classe "Fruit"
        if(!empty($fruit)){
            $fruitInObject = $this->buildDomainObject($fruit);
        }

        // On retourne soir le fruit sous forme d'objet, soit null
        return $fruitInObject ?? null;

    }

    /**
     * Méthode servant à 2 choses :
     * Si le fruit possède déjà un id, alors il sera actualisé dans la BDD
     * Si le fruit ne possède pas d'id, il sera créé dans la BDD
     */
    public function save(Fruit $fruit)
    {

        // Si l'id du fruit est null, alors il faudra le créer en BDD
        if($fruit->getId() == null){

            $createFruit = $this->getDb()->prepare('INSERT INTO fruit(name, color, origin, price_per_kilo, description, user_id) VALUES(?,?,?,?,?,?)');

            // On injecte les données du fruit à créer directement depuis l'objet
            $statut = $createFruit->execute([
                $fruit->getName(),
                $fruit->getColor(),
                $fruit->getOrigin(),
                $fruit->getPricePerKilo(),
                $fruit->getDescription(),
                $fruit->getUser()->getId(), // Ici on doit envoyer l'id de l'utilisateur qui a créé ce fruit, pas tout l'objet renvoyé par getUser()
            ]);

            // Actualisation de l'id dans l'objet
            $newId = $this->getDb()->lastInsertId();
            $fruit->setId($newId);

            // Retour du booléen de réussite/échec
            return $statut;

        } else {

            // Mise à jour du fruit via l'id qu'il contient
            $updateFruit = $this->getDb()->prepare('UPDATE fruit SET name = ?, color = ?, origin = ?, price_per_kilo = ?, description = ?, user_id = ? WHERE id = ?');

            // On injecte les données du fruit à créer directement depuis l'objet
            $statut = $updateFruit->execute([
                $fruit->getName(),
                $fruit->getColor(),
                $fruit->getOrigin(),
                $fruit->getPricePerKilo(),
                $fruit->getDescription(),
                $fruit->getUser()->getId(), // Ici on doit envoyer l'id de l'utilisateur qui a créé ce fruit, pas tout l'objet renvoyé par getUser()
                $fruit->getId(),    // Ce paramètre permet de sélectionner le bon fruit en BDD
            ]);

            // Retour du booléen de réussite/échec
            return $statut;

        }

    }

    /**
     * Méthode servant à supprimer un fruit en BDD
     */
    public function delete(Fruit $fruitToDelete)
    {

        // Requête de suppression
        $deleteFruit = $this->getDb()->prepare('DELETE FROM fruit WHERE id = ?');

        $statut = $deleteFruit->execute([
            $fruitToDelete->getId()
        ]);

        // Retour du booléen de réussite/échec
        return $statut;

    }

    /**
     * Méthode servant à convertir un array de fruit en un objet de la classe "Fruit"
     */
    private function buildDomainObject(array $fruitInfos)
    {

        // Il faut d'abord récupérer l'objet User correspondant à l'utilisateur qui a créé ce fruit via son ID (injection de dépendance)
        $userManager = new UserManager();
        $user = $userManager->findOneBy('id', $fruitInfos['user_id']);

        // Création et hydratation de l'objet
        $fruit = new Fruit();
        $fruit
            ->setId($fruitInfos['id'])
            ->setColor($fruitInfos['color'])
            ->setName($fruitInfos['name'])
            ->setOrigin($fruitInfos['origin'])
            ->setPricePerKilo($fruitInfos['price_per_kilo'])
            ->setUser($user)    // C'est l'objet entier de l'utilisateur qu'on envoi au setter
            ->setDescription($fruitInfos['description'])
        ;

        // Return du fruit en version objet
        return $fruit;
    }


}