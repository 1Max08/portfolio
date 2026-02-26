<?php

namespace controllers;

/**
 * Contrôleur responsable de la gestion des erreurs.
 *
 * Rôle :
 * - Afficher une page d'erreur (ex: 404)
 * - Centraliser la gestion des routes inexistantes
 *
 * Ce contrôleur est généralement appelé lorsque :
 * - La page demandée n'existe pas
 * - La route n'est pas reconnue par le routeur
 */
class ErrorController
{
    /**
     * Affiche la page d'erreur 404.
     *
     * Définit le template correspondant puis charge
     * le layout principal pour affichage.
     *
     * @return void
     */
    public function error(): void
    {
        // Template de la page 404
        $template = "error/404";

        // Chargement du layout principal
        require_once "views/layout.phtml";
    }
}