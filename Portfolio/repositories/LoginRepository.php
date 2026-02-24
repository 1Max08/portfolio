<?php

namespace repositories;

require_once "services/database.php";
require_once "models/User.php";

use models\User;
use PDO;

class LoginRepository {

    private PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }

    public function getUserByEmail(string $email): ?User {
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