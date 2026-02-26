<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Projet.php";

use models\Projet;

/**
 * Repository responsable de la création et récupération des projets.
 *
 * Fournit des méthodes pour :
 * - Récupérer un projet par son identifiant
 * - Créer un nouveau projet
 */
class CreateRepository
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
     * Crée un nouveau projet en base de données.
     *
     * @param Projet $project Objet Projet contenant les informations à insérer
     * @return bool Succès ou échec de l'insertion
     */
    public function createProjet(Projet $project): bool
    {
        $query = $this->pdo->prepare(
            'INSERT INTO projet (titre, description, image, short_description) VALUES (?, ?, ?, ?)'
        );

        $query->execute([
            $project->title,
            $project->description,
            $project->image,
            $project->short_description
        ]);

        return $query->rowCount() > 0;
    }
}