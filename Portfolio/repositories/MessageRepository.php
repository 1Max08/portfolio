<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Message.php";

use models\Message;

/**
 * Repository pour la gestion des messages de contact.
 *
 * Fournit des méthodes pour :
 * - Récupérer tous les messages
 * - Marquer un message comme lu
 * - Supprimer un message
 */
class MessageRepository
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
     * Récupère tous les messages de contact.
     *
     * Fonctionnement :
     * - Exécute une requête SQL pour récupérer tous les messages
     * - Transforme chaque ligne en objet Message
     * - Trie les messages par date de création décroissante
     *
     * @return Message[] Tableau d'objets Message
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM contact_message ORDER BY created_at DESC"
        );
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $messages = [];
        foreach ($rows as $row) {
            $messages[] = new Message(
                (int) $row['id'],
                $row['name'],
                $row['email'],
                $row['subject'] ?? null,
                $row['message'],
                $row['created_at'],
                (bool) $row['is_read']
            );
        }
        return $messages;
    }

    /**
     * Marque un message comme lu.
     *
     * @param int $id Identifiant du message
     */
    public function markAsRead(int $id): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE contact_message SET is_read = 1 WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
    }

    /**
     * Supprime un message par son identifiant.
     *
     * @param int $id Identifiant du message à supprimer
     */
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM contact_message WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
    }
}