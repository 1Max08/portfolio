<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Competence.php";

use models\Competence;

/**
 * Repository responsable de la modification d'une compétence.
 *
 * Fournit des méthodes pour :
 * - Récupérer une compétence par son ID
 * - Mettre à jour une compétence existante
 */
class ChangeCompetenceRepository
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
     * Récupère une compétence par son identifiant.
     *
     * Fonctionnement :
     * - Prépare et exécute une requête SQL pour récupérer la compétence
     * - Retourne un objet Competence si trouvé
     * - Retourne false si aucun résultat
     *
     * @param int $id Identifiant de la compétence
     * @return Competence|bool Objet Competence ou false si non trouvé
     */
    public function getCompetenceById(int $id): Competence|bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM competence WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ? new Competence((int) $row['id'], $row['name'], $row['level']) : false;
    }

    /**
     * Met à jour une compétence existante.
     *
     * @param int $id Identifiant de la compétence
     * @param string $name Nouveau nom de la compétence
     * @param string $level Nouveau niveau de la compétence
     * @return bool Succès ou échec de la mise à jour
     */
    public function updateCompetence(int $id, string $name, string $level): bool
    {
        $stmt = $this->pdo->prepare("UPDATE competence SET name = ?, level = ? WHERE id = ?");
        return $stmt->execute([$name, $level, $id]);
    }
}