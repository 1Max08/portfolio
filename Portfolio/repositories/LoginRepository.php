<?php

namespace repositories;

require_once "services/database.php";

class LoginRepository {

    public function getUserByEmail(string $email): array|bool {
        $pdo = getConnexion();

        $query = $pdo->prepare('SELECT * FROM user WHERE email = ?');
        $query->execute([$email]);

        return $query->fetch();
    }
}