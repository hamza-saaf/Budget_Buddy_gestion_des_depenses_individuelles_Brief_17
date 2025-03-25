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
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
part 2:Advanced Budget Buddy

Développement d'une REST API pour la gestion des dépenses de groupes en utilisant Laravel.
Contexte du projet
💡 Nouvelle Fonctionnalité : Gestion des Dépenses Partagées

📌 Objectif : Faciliter le partage des dépenses lorsqu’un groupe d’amis effectue plusieurs achats ensemble, et calculer automatiquement qui doit combien à qui.

📍 Fonctionnalités Clés:

​

1️⃣ Création et Gestion des Groupes de Dépenses

​

[POST] /api/groups → Créer un groupe de dépenses (nom, membres, devise).

[GET] /api/groups → Lister les groupes auxquels l'utilisateur appartient.

[GET] /api/groups/{id} → Voir les détails d’un groupe (membres, dépenses, soldes).

[DELETE] /api/groups/{id} → Supprimer un groupe (seulement si aucun solde restant).

​

2️⃣ Ajout des Dépenses Partagées

​

[POST] /api/groups/{id}/expenses → Ajouter une dépense partagée avec : Le montant total. Qui a payé (un ou plusieurs membres). Comment diviser la somme (également ou selon des parts définies). [GET] /api/groups/{id}/expenses → Lister toutes les dépenses du groupe.

[DELETE] /api/groups/{id}/expenses/{expenseId} → Supprimer une dépense.

​

🚀 Les utilisateurs peuvent préciser s'ils veulent diviser en parts égales ou selon des pourcentages.

🚀 Si une dépense est payée par plusieurs membres, leur contribution est enregistrée.

​

​

3️⃣ Calcul Automatique des Soldes

​

[GET] /api/groups/{id}/balances → Retourne un résumé clair des dettes : Qui doit combien et à qui ? Liste des transactions recommandées pour équilibrer les comptes.

🚀 Algorithme d’équilibrage : Plutôt que chaque utilisateur rembourse individuellement chaque paiement, on optimise les transactions pour réduire le nombre de virements nécessaires.

🚀 Ex : Si Alice doit 30€ à Bob et Bob doit 30€ à Claire → alors Alice peut payer directement Claire.

​

​

4️⃣ Règlement des Comptes

​

[POST] /api/groups/{id}/settle → Permet d'enregistrer un paiement entre membres pour équilibrer les comptes.

[GET] /api/groups/{id}/history → Voir l’historique des remboursements effectués.

​

🚀Option d’envoi d’un rappel automatique aux amis qui n’ont pas encore réglé leurs dettes !

​

​

💡 Nouvelle Fonctionnalité : Gestion des Dépenses Individuelles

📌 Objectif : Faciliter et améliorer la gestion des dépenses individuelles d'une manière efficace:

📍 Fonctionnalités Clés:

​

​

1️⃣ Gestion Intelligente du Budget et Alertes Automatiques Définition de Budgets Mensuels

​

Budget

​

[POST] /api/budgets → Définir un budget mensuel par catégorie (Alimentation, Transport, Loisirs, etc.).

[GET] /api/budgets → Voir les budgets définis et leur état actuel (dépenses vs plafond).

[PUT] /api/budgets/{id} → Modifier un budget existant.

[DELETE] /api/budgets/{id} → Supprimer un budget.

​

Alertes

​

[GET] /api/alerts → Lister toutes les alertes actives.

​

🚀 Règle d’alerte (exemple : avertir quand une catégorie atteint 80% du budget).

​

​

​

2️⃣ Détection de Dépenses Anormales

​

[GET] /api/expenses/anomalies → Retourne une liste des dépenses suspectes, basées sur :

​

🚀 Une augmentation soudaine des dépenses d’un utilisateur par rapport aux mois précédents.

🚀 Des transactions inhabituelles par rapport aux habitudes de dépense.

🚀Une dépense qui dépasse un certain pourcentage du revenu mensuel moyen de l'utilisateur.

​

​

3️⃣ Automatisation des Transactions Répétitives

​

[POST] /api/recurring-expenses → Ajouter une dépense récurrente (ex : abonnement Netflix, loyer, assurance).

[GET] /api/recurring-expenses → Voir toutes les dépenses récurrentes planifiées.

[DELETE] /api/recurring-expenses/{id} → Supprimer une dépense récurrente.

​

🚀 Chaque dépense récurrente doit être automatiquement ajoutée chaque mois sans intervention de l’utilisateur.

🚀 Si une dépense récurrente dépasse le budget d’une catégorie, une alerte doit être envoyée.

​

​

​

4️⃣ Génération de Rapports Financiers Personnalisés

​

[GET] /api/reports/summary → Générer un résumé des finances de l’utilisateur (revenus, dépenses, solde mensuel).

[GET] /api/reports/custom?start={YYYY-MM-DD}&end={YYYY-MM-DD} → Générer un rapport pour une période personnalisée.

​

​

Modalités pédagogiques
Travail: individuel

Durée de travail: 8 jours

Date de lancement du brief : 17/03/2025 à 09:00

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

