<?php
namespace repositories;

require_once "services/database.php";
require_once "models/ContactMessage.php";

use models\ContactMessage;

class ContactRepository {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

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

    public function getAllMessages(): array {
        $stmt = $this->pdo->query("SELECT * FROM contact_message ORDER BY created_at DESC");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $messages = [];
        foreach ($rows as $row) {
            $messages[] = new ContactMessage(
                (int)$row['id'],
                $row['name'],
                $row['email'],
                $row['subject'] ?? null,
                $row['message'],
                $row['created_at'],
                (bool)$row['is_read']
            );
        }

        return $messages;
    }
}