# Budget_Buddy_gestion_des_depenses_individuelles_Brief_17
BudgetBuddy: gestion des dépenses individuelles.
Développement d'une REST API pour la gestion des dépenses individuelles en utilisant Laravel.
Contexte du projet
API BudgetBuddy

​

Dans le cadre de l'amélioration de l'expérience utilisateur, notre plateforme BudgetBuddy souhaite offrir une API sécurisée permettant aux utilisateurs de gérer leurs dépenses de manière efficace. L'utilisation de Laravel Sanctum pour l'authentification garantira la sécurité des données tout en permettant un accès contrôlé aux fonctionnalités de gestion des dépenses.

​

​

Fonctionnalités Clés

​

Authentification avec Laravel Sanctum

Mise en place de l'authentification des utilisateurs via Laravel Sanctum pour sécuriser l'accès à l'API.

​

[POST] `/api/register` → Inscription d'un nouvel utilisateur.

[POST] `/api/login` → Connexion et obtention d'un token d'accès.

[POST] `/api/logout` → Déconnexion et invalidation du token d'accès.

[GET] `/api/user` → Récupération des informations de l'utilisateur authentifié.

​

Gestion des Dépenses

[POST] `/api/expenses` → Créer une nouvelle dépense associée à l'utilisateur authentifié.

[GET] `/api/expenses` → Lister toutes les dépenses de l'utilisateur authentifié.

[GET] `/api/expenses/{id}` → Afficher une dépense spécifique de l'utilisateur authentifié.

[PUT] `/api/expenses/{id}` → Modifier une dépense appartenant à l'utilisateur authentifié.

[DELETE] `/api/expenses/{id}` → Supprimer une dépense appartenant à l'utilisateur authentifié.

​

​

Gestion des Tags

[POST] `/api/tags` → Créer un tag.

[GET] `/api/tags` → Lister tous les tags.

[GET] `/api/tags/{id}` → Afficher un tag spécifique.

[PUT] `/api/tags/{id}` → Modifier un tag.

[DELETE] `/api/tags/{id}` → Supprimer un tag.

[POST] `/api/expenses/{id}/tags` → Associer des tags à une dépense.

​

​

Contraintes Techniques

​

​

Politiques d'Accès :** **Utilisation de policies pour garantir que chaque utilisateur ne peut gérer que ses propres dépenses et tags.

Tests sur Postman:** **Création de scénarios de test dans Postman pour valider les endpoints dans différents cas d’utilisation.

Documentation de l’API:** **Rédaction d’une documentation détaillée via Swagger ou API Blueprint, incluant les routes, paramètres et réponses attendues.

​

​

Technologies Requises

Laravel : Développement de l’API.
Laravel Sanctum : Authentification sécurisée.
Postman : Tests d’intégration.
Swagger/API Blueprint : Documentation de l’API.
Modalités pédagogiques
Travail: individuel

Durée de travail: 4 jours

Date de lancement du brief : 10/03/2025 à 09:15

Date limite de soumission: 14/03/2025 avant 12:00

Modalités d'évaluation
Vous présenterez votre travail en français:
- 5 minutes : Simulation de l'application web attendu.
- 5 minutes : Code Review + Questions Techniques
- 10 minutes : mise en situation individuelle.

Livrables
- Répartition des tâches sur un Scrum Board avec tous les U.S + Lien de Repository Github du projet
- Documentation API

Critères de performance
Temps de réponse de l'API.
Sécurité de l'authentification.
Fiabilité des opérations CRUD.
Gestion des erreurs.
Conformité aux politiques d'accès.
Testabilité.
Documentation claire et complète.
