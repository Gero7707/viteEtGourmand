# 📋 User Stories — Vite & Gourmand

## 🔵 Visiteur (personne non authentifiée)

| ID | User Story | Priorité |
|---|---|---|
| V-01 | En tant que visiteur, je veux consulter la page d'accueil afin de découvrir l'entreprise et lire les avis clients. | Must |
| V-02 | En tant que visiteur, je veux consulter la liste des menus afin de trouver un menu adapté à mon événement. | Must |
| V-03 | En tant que visiteur, je veux filtrer les menus par thème, régime, prix et nombre de personnes afin de trouver rapidement un menu correspondant à mes critères. | Must |
| V-04 | En tant que visiteur, je veux consulter le détail d'un menu afin de connaître sa composition, ses conditions et ses allergènes. | Must |
| V-05 | En tant que visiteur, je veux estimer le prix d'un menu selon le nombre de personnes afin de vérifier que mon budget est suffisant. | Should |
| V-06 | En tant que visiteur, je veux contacter le prestataire afin d'obtenir plus d'informations sur ses services. | Must |
| V-07 | En tant que visiteur, je veux créer un compte afin de pouvoir commander un menu. | Must |
| V-08 | En tant que visiteur, je veux consulter les mentions légales afin de connaître la politique de données. | Must |
| V-09 | En tant que visiteur, je veux consulter les CGV afin de connaître les conditions avant de passer commande. | Must |

---

## 🟢 Utilisateur (personne authentifiée)

> L'utilisateur peut faire tout ce qu'un visiteur peut faire, plus les actions suivantes.

| ID | User Story | Priorité |
|---|---|---|
| U-01 | En tant qu'utilisateur, je veux me connecter afin d'accéder à mon espace personnel. | Must |
| U-02 | En tant qu'utilisateur, je veux réinitialiser mon mot de passe afin de récupérer l'accès à mon compte en cas d'oubli. | Must |
| U-03 | En tant qu'utilisateur, je veux commander un menu afin de réserver une prestation traiteur pour mon événement. | Must |
| U-04 | En tant qu'utilisateur, je veux visualiser mes commandes en détail afin de retrouver l'historique de mes prestations. | Must |
| U-05 | En tant qu'utilisateur, je veux modifier ma commande afin de corriger une erreur (tant que la commande n'est pas acceptée). | Must |
| U-06 | En tant qu'utilisateur, je veux annuler ma commande afin de renoncer à une prestation (tant que la commande n'est pas acceptée). | Must |
| U-07 | En tant qu'utilisateur, je veux suivre ma commande afin de connaître son statut en temps réel. | Must |
| U-08 | En tant qu'utilisateur, je veux modifier mes informations personnelles afin de mettre à jour mon profil. | Should |
| U-09 | En tant qu'utilisateur, je veux donner un avis après une commande terminée afin de partager mon niveau de satisfaction. | Must |

---

## 🟠 Employé

> L'employé accède à son espace après connexion.

| ID | User Story | Priorité |
|---|---|---|
| E-01 | En tant qu'employé, je veux modifier les menus et les plats afin de mettre à jour l'offre proposée aux clients. | Must |
| E-02 | En tant qu'employé, je veux supprimer un menu ou un plat afin de retirer une offre qui n'est plus disponible. | Must |
| E-03 | En tant qu'employé, je veux modifier les horaires afin de tenir à jour les informations de l'entreprise. | Must |
| E-04 | En tant qu'employé, je veux filtrer les commandes par statut ou par client afin de retrouver rapidement une commande à traiter. | Must |
| E-05 | En tant qu'employé, je veux mettre à jour le statut d'une commande afin d'assurer le suivi du processus de livraison. | Must |
| E-06 | En tant qu'employé, je veux annuler une commande après avoir contacté le client afin de justifier l'annulation avec un motif et un mode de contact. | Must |
| E-07 | En tant qu'employé, je veux valider ou refuser un avis client afin de modérer le contenu affiché sur la page d'accueil. | Must |

---

## 🔴 Administrateur

> L'administrateur peut faire tout ce qu'un employé peut faire, plus les actions suivantes.

| ID | User Story | Priorité |
|---|---|---|
| A-01 | En tant qu'administrateur, je veux créer un compte employé afin de lui donner accès à l'application. | Must |
| A-02 | En tant qu'administrateur, je veux désactiver un compte employé afin de supprimer son accès en cas de départ de l'entreprise. | Must |
| A-03 | En tant qu'administrateur, je veux visualiser le nombre de commandes par menu via un graphique afin de comparer la popularité des menus. | Must |
| A-04 | En tant qu'administrateur, je veux consulter le chiffre d'affaires par menu avec des filtres par menu et par durée afin de suivre la performance commerciale. | Must |

---

## 📌 Légende des priorités (méthode MoSCoW)

| Priorité | Signification |
|---|---|
| **Must** | Indispensable — l'application ne fonctionne pas sans |
| **Should** | Important — forte valeur ajoutée mais pas bloquant |
| **Could** | Souhaitable — si le temps le permet |
| **Won't** | Exclu — hors périmètre pour cette version |

---

## 📝 Notes

- **V-05 (Estimation du prix)** : amélioration UX proposée par le développeur. Permet au visiteur d'estimer le prix sans créer de compte. Le calcul tient compte du prix par personne et de la réduction de 10% (≥ 5 personnes au-dessus du minimum). Les frais de livraison restent visibles uniquement à l'étape de commande (après connexion) car ils nécessitent l'adresse du client.
- **Héritage des rôles** : Utilisateur hérite des droits du Visiteur. Administrateur hérite des droits de l'Employé.
- **Compte administrateur** : créé directement par le développeur, impossible à créer depuis l'application.
- **Données statistiques (A-03)** : doivent provenir d'une base de données non relationnelle (MongoDB).
