<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Projet.php";
require_once "models/Profil.php";

use models\Projet;
use models\Profil;

/**
 * Repository responsable de la récupération des informations
 * pour la page "À propos" (About) et les projets.
 *
 * Fonctionnalités :
 * - Récupérer le profil principal
 * - Récupérer tous les projets
 *
 * Utilise PDO pour interagir avec la base de données.
 */
class AboutRepository
{
    /**
     * Instance PDO pour la connexion à la base de données.
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
     * Récupère le profil principal.
     *
     * Fonctionnement :
     * - Exécute une requête SQL pour récupérer le profil avec id = 1
     * - Retourne un objet Profil si trouvé
     * - Retourne null si aucun profil trouvé
     *
     * @return Profil|null Objet Profil ou null si non trouvé
     */
    public function getProfil(): ?Profil
    {
        $query = $this->pdo->prepare('SELECT * FROM profil WHERE id = 1');
        $query->execute();
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Profil(
            (int) $data['id'],
            $data['introduction'] ?? '',
            $data['description'] ?? '',
            $data['profil_image'] ?? ''
        );
    }

    /**
     * Récupère tous les projets de la base.
     *
     * Fonctionnement :
     * - Exécute une requête SQL pour récupérer tous les projets
     * - Transforme chaque ligne en objet Projet
     * - Retourne un tableau d'objets Projet
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