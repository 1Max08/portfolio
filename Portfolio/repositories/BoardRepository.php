<?php
namespace repositories;

require_once "services/database.php";
require_once "repositories/AbstractRepository.php";
require_once "models/Profil.php";
require_once "models/Projet.php";

use models\Profil;
use models\Projet;

/**
 * Repository central pour la page "Board".
 *
 * Fournit l'accès aux données principales :
 * - Profil
 * - Projets
 * - Compétences
 *
 * Hérite de AbstractRepository pour la connexion PDO.
 */
class BoardRepository extends AbstractRepository
{
    /**
     * Récupère le profil principal (id = 1).
     *
     * @return Profil Objet Profil
     */
    public function getProfil(): Profil
    {
        $query = $this->pdo->prepare('SELECT * FROM profil WHERE id = 1');
        $query->execute();
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        return new Profil(
            (int) $data['id'],
            $data['introduction'] ?? '',
            $data['description'] ?? '',
            $data['profil_image'] ?? ''
        );
    }

    /**
     * Récupère tous les projets.
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

    /**
     * Met à jour le profil principal.
     *
     * @param string $introduction Introduction du profil
     * @param string $description Description complète
     * @param string $profil_image Nom du fichier image
     * @return bool Succès ou échec de la requête
     */
    public function updateProfil(string $introduction, string $description, string $profil_image): bool
    {
        $query = $this->pdo->prepare(
            'UPDATE profil SET introduction = ?, description = ?, profil_image = ? WHERE id = 1'
        );

        return $query->execute([$introduction, $description, $profil_image]);
    }

    /**
     * Supprime un projet par son identifiant.
     *
     * @param int $id Identifiant du projet à supprimer
     * @return void
     */
    public function deleteProjet(int $id): void
    {
        $sql = "DELETE FROM projet WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Récupère toutes les compétences.
     *
     * @return object[] Tableau d'objets représentant les compétences
     */
    public function getCompetences(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM competence ORDER BY id ASC");
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Récupère une compétence par son identifiant.
     *
     * @param int $id Identifiant de la compétence
     * @return object|null Objet compétence ou null si non trouvé
     */
    public function getCompetenceById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM competence WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Ajoute une nouvelle compétence.
     *
     * @param string $name Nom de la compétence
     * @param string $level Niveau de maîtrise
     * @return bool Succès ou échec de l'insertion
     */
    public function addCompetence(string $name, string $level): bool
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
    public function deleteCompetence(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM competence WHERE id = ?");
        return $stmt->execute([$id]);
    }
}