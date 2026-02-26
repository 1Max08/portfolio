# Portfolio – README

## Présentation

Ce projet est un **portfolio personnel** permettant de présenter mes compétences, expériences et projets.  
Le site est entièrement dynamique et permet la gestion complète des contenus via un **tableau de bord administrateur**.

---

## Accès et connexion

- Pour accéder au site, ouvrez :  
  `index.php?page=about`

- **Compte administrateur** :  
  - Email : `admin@admin.fr`  
  - Mot de passe : `admin`  

> L’accès admin permet de gérer le profil, les compétences, les expériences et les projets depuis le **dashboard**.

---

## Fonctionnalités

- **Visualisation publique** :  
  - Affichage des expériences, projets et compétences.  
  - Formulaire de contact pour envoyer des messages.

- **Tableau de bord admin** :  
  - Modifier le **profil** (introduction, description, image).  
  - Ajouter, modifier ou supprimer les **compétences**.  
  - Ajouter, modifier ou supprimer les **expériences**.  
  - Ajouter, modifier ou supprimer les **projets**.

> ⚠️ Remarque : L’envoi de mails depuis le formulaire de contact n’a pas été testé sous **MAMP**, car ce serveur local ne supporte pas l’envoi de mails. Les messages sont cependant bien enregistrés dans la base de données.

---

## Utilisation de l’IA

L’intelligence artificielle a été utilisée pour :  
- Corriger les bugs.  
- Ajouter des commentaires et de la documentation dans le code.  

---

## Configuration

- PHP 8+ avec PDO activé.  
- Base de données configurée via `services/database.php`.  
- Tous les formulaires utilisent `htmlspecialchars()` pour protéger contre les injections XSS.  
- Les routes sont gérées par un routeur centralisé dans `index.php`.

---