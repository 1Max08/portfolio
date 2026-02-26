<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Experience.php";

use models\Experience;

/**
 * Repository pour la gestion des expériences.
 *
 * Fournit des méthodes pour :
 * - Récupérer une expérience par son identifiant
 * - Récupérer toutes les expériences
 * - Créer une nouvelle expérience
 * - Mettre à jour une expérience existante
 * - Supprimer une expérience
 */
class ExperienceRepository
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
     * Récupère une expérience par son identifiant.
     *
     * @param int $id Identifiant de l'expérience
     * @return Experience|null Objet Experience ou null si non trouvé
     */
    public function getExperienceById(int $id): ?Experience
    {
        $query = $this->pdo->prepare('SELECT * FROM experience WHERE id = :id');
        $query->bindParam(':id', $id, \PDO::PARAM_INT);
        $query->execute();

        $data = $query->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        return new Experience(
            (int) $data['id'],
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['short_description'] ?? '',
            $data['image'] ?? ''
        );
    }

    /**
     * Récupère toutes les expériences.
     *
     * @return Experience[] Tableau d'objets Experience
     */
    public function getExperience(): array
    {
        $query = $this->pdo->prepare('SELECT * FROM experience ORDER BY id ASC');
        $query->execute();
        $rows = $query->fetchAll(\PDO::FETCH_ASSOC);

        $items = [];
        foreach ($rows as $row) {
            $items[] = new Experience(
                (int) $row['id'],
                $row['title'] ?? '',
                $row['description'] ?? '',
                $row['short_description'] ?? '',
                $row['image'] ?? ''
            );
        }

        return $items;
    }

    /**
     * Crée une nouvelle expérience en base de données.
     *
     * @param Experience $exp Objet Experience contenant les informations à insérer
     * @return bool Succès ou échec de l'insertion
     */
    public function createExperience(Experience $exp): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO experience (title, description, image, short_description) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([
            $exp->title,
            $exp->description,
            $exp->image,
            $exp->short_description
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Met à jour une expérience existante.
     *
     * @param int $id Identifiant de l'expérience
     * @param string $title Nouveau titre
     * @param string $description Nouvelle description complète
     * @param string $image Nouveau nom de l'image
     * @param string $short_description Nouvelle description courte
     * @return bool Succès ou échec de la mise à jour
     */
    public function updateExperience(int $id, string $title, string $description, string $image, string $short_description): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE experience SET title = ?, description = ?, image = ?, short_description = ? WHERE id = ?'
        );
        $stmt->execute([$title, $description, $image, $short_description, $id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Supprime une expérience par son identifiant.
     *
     * @param int $id Identifiant de l'expérience à supprimer
     * @return bool Succès ou échec de la suppression
     */
    public function deleteExperience(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM experience WHERE id = ?');
        return $stmt->execute([$id]);
    }
}