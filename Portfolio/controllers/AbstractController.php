<?php
/**
 * controllers/AbstractController.php
 *
 * Classe de base pour les contrôleurs. Fournit des méthodes utilitaires
 * courantes utilisées par les contrôleurs enfants : démarrage de session,
 * vérification d'authentification et déconnexion.
 */
namespace controllers;

abstract class AbstractController
{
    /**
     * Démarre la session PHP si elle n'est pas déjà démarrée.
     * Utiliser cette méthode avant d'accéder à `$_SESSION` pour éviter
     * des erreurs de session non initialisée.
     */
    protected function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Vérifie qu'un utilisateur est connecté.
     * Si aucun utilisateur n'est présent en session, redirige vers la
     * page publique `about` (ou la page de connexion selon la logique).
     *
     * Cette méthode appelle `startSession()` pour s'assurer que la session
     * est disponible.
     */
    protected function requireLogin()
    {
        $this->startSession();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=about");
            exit;
        }
    }

    /**
     * Déconnecte l'utilisateur courant : détruit la session, efface les
     * variables de session et supprime le cookie de session, puis redirige
     * vers la page de connexion.
     *
     * Appeler cette méthode lorsque l'on souhaite forcer la déconnexion
     * (par exemple lors d'un clic sur "Déconnexion").
     */
    protected function logout()
    {
        $this->startSession();
        // Vider et détruire la session
        $_SESSION = [];
        session_unset();
        session_destroy();
        // Supprimer le cookie de session côté client
        setcookie(session_name(), '', time() - 3600);
        // Redirection vers la page de connexion
        header("Location: index.php?page=login");
        exit;
    }
}