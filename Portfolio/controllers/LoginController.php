<?php

namespace controllers;

require_once "repositories/LoginRepository.php";

use repositories\LoginRepository;
use models\User;

/**
 * Contrôleur responsable de la gestion de la connexion utilisateur.
 *
 * Fonctionnalités :
 * - Affichage du formulaire de connexion
 * - Vérification des identifiants
 * - Gestion de la session utilisateur
 */
class LoginController
{
    /**
     * Repository permettant l'accès aux données utilisateurs.
     *
     * @var LoginRepository
     */
    private LoginRepository $loginRepository;

    /**
     * Constructeur du contrôleur.
     *
     * Initialise le repository et démarre la session si nécessaire.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->loginRepository = new LoginRepository();
    }

    /**
     * Gère la connexion de l'utilisateur.
     *
     * Fonctionnement :
     * - Affiche le formulaire de login
     * - Si le formulaire est soumis :
     *      - Récupère l'utilisateur via l'email
     *      - Vérifie le mot de passe avec password_verify
     *      - En cas de succès, stocke l'utilisateur en session et redirige vers le tableau de bord
     *      - Sinon, redirige de nouveau vers la page de login
     *
     * @return void
     */
    public function login(): void
    {
        $template = "login/login";
        require_once "views/layout.phtml";

        // Vérifie si les champs email et mot de passe sont remplis
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Récupération de l'utilisateur en base
            $user = $this->loginRepository->getUserByEmail($email);

            // Vérification du mot de passe et connexion
            if ($user instanceof User && password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = $user;
                header("Location: index.php?page=board");
                exit();
            } else {
                // Échec : redirection vers login
                header("Location: index.php?page=login");
                exit();
            }
        }
    }
}