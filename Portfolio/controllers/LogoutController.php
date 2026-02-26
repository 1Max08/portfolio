<?php

namespace controllers;

use models\User;
require_once "AbstractController.php";
require_once "models/User.php";

/**
 * Contrôleur responsable de la déconnexion utilisateur.
 *
 * Fonctionnalités :
 * - Supprimer la session utilisateur
 * - Détruire les données de session et le cookie associé
 * - Rediriger l'utilisateur après déconnexion
 *
 * Hérite de AbstractController pour :
 * - La gestion de la session (si nécessaire)
 */
class LogoutController extends AbstractController
{
    /**
     * Déconnecte l'utilisateur actuel.
     *
     * Fonctionnement :
     * - Vérifie si la session est démarrée, sinon la démarre
     * - Supprime toutes les variables de session
     * - Détruit la session et le cookie de session
     * - Redirige vers la page "about" après déconnexion
     *
     * @return void
     */
    public function logout(): void
    {
        // Démarrage de la session si elle n'existe pas
        if (!isset($_SESSION)) {
            session_start();
        }

        // Vérifie si un utilisateur est connecté
        if (isset($_SESSION['user']) && $_SESSION['user'] instanceof User) {

            // Suppression des données de session
            $_SESSION = [];
            session_unset();
            session_destroy();

            // Suppression du cookie de session
            setcookie(session_name(), '', time() - 3600);
        }

        // Redirection après déconnexion
        header("Location: index.php?page=about");
        exit;
    }
}