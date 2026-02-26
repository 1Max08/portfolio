<?php

namespace repositories;

require_once "services/database.php";
require_once "models/Projet.php";

use models\Projet;

/**
 * Repository responsable de la modification d'un projet.
 *
 * Fournit des méthodes pour :
 * - Récupérer un projet par son identifiant
 * - Mettre à jour un projet existant
 */
class ChangeRepository
{
    /**
     * Instance PDO pour accéder à la base de données.
     *
     * @var \PDO
     */
    private $pdo;

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
        $query = $this->pdo->prepare(
            'SELECT * FROM projet WHERE id = :id'
        );
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Projet(
            (int)$data['id'],
            $data['titre'] ?? '',
            $data['description'] ?? '',
            $data['short_description'] ?? '',
            $data['image'] ?? ''
        );
    }

    /**
     * Met à jour un projet existant.
     *
     * @param int $id Identifiant du projet
     * @param string $titre Nouveau titre du projet
     * @param string $description Nouvelle description complète
     * @param string $image Nouveau nom du fichier image
     * @param string $short_description Nouvelle description courte
     * @return bool Succès ou échec de la mise à jour
     */
    public function updateProjet(
        int $id,
        string $titre,
        string $description,
        string $image,
        string $short_description
    ): bool {
        $query = $this->pdo->prepare(
            'UPDATE projet 
             SET titre = ?, description = ?, image = ?, short_description = ? 
             WHERE id = ?'
        );

        $query->execute([
            $titre,
            $description,
            $image,
            $short_description,
            $id
        ]);

        return $query->rowCount() > 0;
    }
}