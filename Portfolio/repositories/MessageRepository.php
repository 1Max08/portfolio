<?php
namespace repositories;

require_once "services/database.php";
require_once "models/Message.php";

use models\Message;

class MessageRepository {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM contact_message ORDER BY created_at DESC");
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $messages = [];
        foreach ($rows as $row) {
            $messages[] = new Message(
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

    public function markAsRead(int $id): void {
        $stmt = $this->pdo->prepare("UPDATE contact_message SET is_read = 1 WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function delete(int $id): void {
        $stmt = $this->pdo->prepare("DELETE FROM contact_message WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}