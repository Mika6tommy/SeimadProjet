# SeimadProjet

Ce projet est une application web développée avec le framework Symfony. Il utilise plusieurs bundles et services, notamment Doctrine pour la gestion des bases de données, Messenger pour les files de messages, et Mailer pour l'envoi d'e-mails.

## Prérequis

- PHP 8.0 ou supérieur
- Composer
- MySQL ou MariaDB
- Serveur de messagerie SMTP (ex. Mailtrap pour un environnement de développement)

## Installation

1. Cloner le dépôt sur votre machine :

   ```bash
   git clone https://github.com/Mika6tommy/SeimadProjet.git
   cd SeimadProjet

2. Installer les dépendances avec Composer :

    composer install

3. Lancer les migrations de base de données (si nécessaire) :

    php bin/console doctrine:migrations:migrate

Pour démarrer le serveur de développement Symfony, exécutez la commande suivante :

symfony serve

(il faut installer symfony cli et les autres composants)