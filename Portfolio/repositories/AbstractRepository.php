<?php

namespace repositories;

require_once "services/database.php";

/**
 * Classe abstraite pour les repositories.
 *
 * Fournit une connexion PDO partagée et définit
 * l'interface minimale que tous les repositories doivent implémenter.
 *
 * Fonctionnalités :
 * - Initialisation de la connexion à la base de données
 * - Définition d'une méthode abstraite getProjet() pour récupérer des projets
 *
 * Les classes filles doivent implémenter la méthode getProjet().
 */
abstract class AbstractRepository
{
    /**
     * Instance PDO pour accéder à la base de données.
     *
     * @var \PDO
     */
    protected \PDO $pdo;

    /**
     * Constructeur de la classe abstraite.
     *
     * Initialise la connexion PDO via la fonction getConnexion().
     */
    public function __construct()
    {
        $this->pdo = getConnexion();
    }

    /**
     * Méthode abstraite à implémenter par les classes filles.
     *
     * Doit retourner un tableau d'objets Projet.
     *
     * @return array Tableau d'objets Projet
     */
    abstract public function getProjet(): array;
}