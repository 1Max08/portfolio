<?php

namespace repositories;

require_once "services/database.php";
require_once "models/User.php";

use models\User;
use PDO;

/**
 * Repository pour la gestion des utilisateurs.
 *
 * Fournit des méthodes pour :
 * - Récupérer un utilisateur par son email
 */
class LoginRepository
{
    /**
     * Instance PDO pour accéder à la base de données.
     *
     * @var PDO
     */
    private PDO $pdo;

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
     * Récupère un utilisateur par son email.
     *
     * Fonctionnement :
     * - Prépare et exécute une requête SQL pour récupérer l'utilisateur
     * - Retourne un objet User si trouvé
     * - Retourne null si aucun utilisateur ne correspond
     *
     * @param string $email Email de l'utilisateur
     * @return User|null Objet User ou null si non trouvé
     */
    public function getUserByEmail(string $email): ?User
    {
        $query = $this->pdo->prepare('SELECT * FROM user WHERE email = ?');
        $query->execute([$email]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return new User(
            (int) $result['id'],
            $result['email'],
            $result['password']
        );
    }
}