# Introduction

Dans le cadre de la formation, les propositions de live coding, veilles et workshops sont actuellement gérées manuellement via des fichiers partagés, ce qui entraîne un manque de visibilité, des doublons et une gestion chronophage pour le formateur.

Le projet Proposia vise à digitaliser ce processus afin d’améliorer l’organisation, la traçabilité et l’efficacité pédagogique.

## Cahier des charge

### 1. Présentation du projet

-Nom  : Proposia

-Type : Plateforme de gestion et validation de propositions pédagogiques.

-Utilisateurs : Étudiants, Formateur

 -But : Centraliser la gestion des propositions de live coding, veilles et workshops.

### 2. Fonctionnalités

#### 2.1 Fonctionnalités – Étudiant

-Authentification

-Soumission d’une proposition

-Titre

-Type (live coding / veille / workshop)

-Description

-Date souhaitée

-Consultation de ses propositions

-Suivi du statut

-Consultation du planning validé

#### 2.2 Fonctionnalités – Formateur

-Authentification

Consultation de toutes les propositions

-Validation ou refus avec commentaire

-Création de propositions

-Assignation d’un sujet à un ou plusieurs étudiants

-Gestion du planning

-Visualisation globale

### 3. Règles de gestion

-Une proposition a un seul statut à la fois

-Une proposition validée devient visible dans le planning

-Un étudiant ne peut modifier une proposition qu’avant validation

-Le formateur a tous les droits

-Historique conservé (traçabilité pédagogique)

### 4. Acteurs

    Acteur          Rôle

    Étudiant    Soumettre, consulter, suivre

    Formateur   Créer, modifier, supprimer, valider, Proposer, consulter
    

### 5. Contraintes techniques

-Architecture : MVC avec separation claire des résponsabilités

-Base de données : Base de données relationnelle normalisée (MySQL)

-Backend : PHP (POO)

-Frontend : HTML / Tailwind / JS

-Frameworks / Bibliothèques : Utilisation de Composer pour la gestion des dépendances

-Sécurité : Authentification par rôles, validation des entrées utilisateur, protection contre les injections (validation, sessions, CSRF)
