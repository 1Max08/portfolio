<?php
namespace repositories;

require_once "services/database.php";
require_once "models/ContactMessage.php";

use models\ContactMessage;

/**
 * Repository pour la gestion des messages de contact.
 *
 * Fournit des méthodes pour :
 * - Enregistrer un nouveau message
 * - Récupérer tous les messages existants
 */
class ContactRepository
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
     * Enregistre un nouveau message de contact en base de données.
     *
     * @param string $name Nom de l'expéditeur
     * @param string $email Email de l'expéditeur
     * @param string|null $subject Sujet du message (optionnel)
     * @param string $message Contenu du message
     * @return bool Succès ou échec de l'insertion
     */
    public function saveMessage(
        string $name,
        string $email,
        ?string $subject,
        string $message
    ): bool {
        $query = $this->pdo->prepare(
            "INSERT INTO contact_message (name, email, subject, message)
             VALUES (:name, :email, :subject, :message)"
        );

        return $query->execute([
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ]);
    }

    /**
     * Récupère tous les messages de contact existants.
     *
     * Fonctionnement :
     * - Exécute une requête SQL pour récupérer tous les messages
     * - Transforme chaque ligne en objet ContactMessage
     * - Trie les messages par date de création décroissante
     *
     * @return ContactMessage[] Tableau d'objets ContactMessage
     */
    public function getAllMessages(): array
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM contact_message ORDER BY created_at DESC"
        );
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $messages = [];
        foreach ($rows as $row) {
            $messages[] = new ContactMessage(
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
}