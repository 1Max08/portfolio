<?php

namespace repositories;

require_once "services/database.php";
require_once "models/Projet.php";

use models\Projet;

/**
 * Repository pour la gestion des projets.
 *
 * Fournit des méthodes pour :
 * - Récupérer un projet par son identifiant
 * - Récupérer tous les projets
 */
class ProjetRepository
{
    /**
     * Instance PDO pour accéder à la base de données.
     *
     * @var \PDO
     */
    private \PDO $pdo;

    /**
     * Constructeur du repository.
     *
     * Initialise la connexion PDO via la fonction getConnexion().
     */
    public function __construct()
    {
        $this->pdo = getConnexion();
    }

    /**
     * Récupère un projet par son identifiant.
     *
     * Fonctionnement :
     * - Prépare et exécute une requête SQL pour récupérer le projet
     * - Retourne un objet Projet si trouvé
     * - Retourne null si aucun résultat
     *
     * @param int $id Identifiant du projet
     * @return Projet|null Objet Projet ou null si non trouvé
     */
    public function getProjetById(int $id): ?Projet
    {
        $query = $this->pdo->prepare('SELECT * FROM projet WHERE id = :id');
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Projet(
            (int) $data['id'],
            $data['titre'] ?? '',
            $data['description'] ?? '',
            $data['short_description'] ?? '',
            $data['image'] ?? ''
        );
    }

    /**
     * Récupère tous les projets.
     *
     * Fonctionnement :
     * - Exécute une requête SQL pour récupérer tous les projets
     * - Transforme chaque ligne en objet Projet
     *
     * @return Projet[] Tableau d'objets Projet
     */
    public function getProjet(): array
    {
        $query = $this->pdo->prepare('SELECT * FROM projet');
        $query->execute();

        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);

        $projects = [];
        foreach ($rows as $row) {
            $projects[] = new Projet(
                (int) $row['id'],
                $row['titre'] ?? '',
                $row['description'] ?? '',
                $row['short_description'] ?? '',
                $row['image'] ?? ''
            );
        }

        return $projects;
    }
}