<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Competence.php";

use models\Competence;

/**
 * Repository pour la gestion des compétences.
 *
 * Fournit des méthodes pour :
 * - Récupérer toutes les compétences
 * - Ajouter une nouvelle compétence
 * - Supprimer une compétence existante
 */
class CompetenceRepository
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
     * Récupère toutes les compétences.
     *
     * Fonctionnement :
     * - Exécute une requête SQL pour récupérer toutes les compétences
     * - Transforme chaque ligne en objet Competence
     * - Retourne un tableau d'objets Competence
     *
     * @return Competence[] Tableau d'objets Competence
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM competence ORDER BY id ASC");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $competences = [];
        foreach ($rows as $row) {
            $competences[] = new Competence(
                (int) $row['id'],
                $row['name'] ?? '',
                $row['level'] ?? ''
            );
        }
        return $competences;
    }

    /**
     * Ajoute une nouvelle compétence en base de données.
     *
     * @param string $name Nom de la compétence
     * @param string $level Niveau de maîtrise
     * @return bool Succès ou échec de l'insertion
     */
    public function add(string $name, string $level): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO competence (name, level) VALUES (?, ?)");
        return $stmt->execute([$name, $level]);
    }

    /**
     * Supprime une compétence par son identifiant.
     *
     * @param int $id Identifiant de la compétence à supprimer
     * @return bool Succès ou échec de la suppression
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM competence WHERE id = ?");
        return $stmt->execute([$id]);
    }
}