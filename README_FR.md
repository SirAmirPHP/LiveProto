# Bot Telegram de Reconnaissance Musicale

Ce bot Telegram peut identifier la musique depuis Instagram Reels. Les utilisateurs peuvent envoyer des liens Instagram Reels et le bot identifiera le nom de la chanson et l'artiste.

## Caractéristiques

- 🎵 Reconnaissance musicale depuis Instagram Reels
- 🎤 Afficher le nom de l'artiste et de la chanson
- 💿 Afficher les informations de l'album (si disponible)
- 📅 Afficher l'année de sortie
- 🎯 Afficher le pourcentage de confiance
- 💾 Sauvegarder l'historique en base de données
- 🔒 Haute sécurité et protection des données

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- FFmpeg (pour extraire l'audio de la vidéo)
- Extensions PHP: curl, json, pdo, pdo_mysql
- Certificat SSL (pour webhook)

## Installation

### 1. Télécharger les Fichiers

Téléchargez tous les fichiers du projet sur votre hébergement cPanel.

### 2. Exécuter l'Installation

Exécutez `install.php` dans votre navigateur pour vérifier les prérequis.

### 3. Configurer la Base de Données

1. Créer une base de données MySQL
2. Modifier `config.php` et entrer les informations de la base de données

### 4. Créer un Bot Telegram

1. Discuter avec [@BotFather](https://t.me/botfather) sur Telegram
2. Envoyer la commande `/newbot`
3. Choisir le nom du bot et le nom d'utilisateur
4. Copier le token du bot
5. Entrer le token dans `config.php`

### 5. Configurer les APIs

#### Instagram Basic Display API
1. Aller sur [Facebook Developers](https://developers.facebook.com/)
2. Créer une nouvelle application
3. Ajouter Instagram Basic Display
4. Obtenir la clé API

#### ACRCloud API (Reconnaissance Musicale)
1. Aller sur [ACRCloud](https://www.acrcloud.com/)
2. Créer un compte
3. Obtenir la clé API

### 6. Configurer le Webhook

Exécuter `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Tester le Bot

Exécuter `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Utilisation

1. Trouver le bot sur Telegram
2. Envoyer la commande `/start`
3. Envoyer le lien Instagram Reels
4. Attendre l'identification de la musique

## Structure des Fichiers

```
/
├── config.php              # Configuration principale
├── database.php            # Classe de base de données
├── instagram_handler.php   # Traitement Instagram
├── music_recognizer.php    # Reconnaissance musicale
├── telegram_bot.php        # Classe du bot Telegram
├── webhook.php            # Gestionnaire webhook
├── setup.php              # Configuration
├── test.php               # Tests du bot
├── install.php            # Installation
├── index.php              # Page principale
└── README.md              # Documentation
```

## APIs Supportées

### Reconnaissance Musicale
- **ACRCloud**: Service principal de reconnaissance musicale
- **Shazam**: Alternative à ACRCloud

### Instagram
- **Instagram Basic Display API**: Accès au contenu Instagram

## Paramètres Avancés

### Limites de Fichiers
Dans le fichier `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Sécurité
- Protéger `config.php` de l'accès public
- Utiliser un certificat SSL valide
- Choisir des mots de passe forts

## Dépannage

### Problèmes Courants

1. **Erreur de Connexion à la Base de Données**
   - Vérifier les informations de la base de données
   - S'assurer que la base de données est créée

2. **Erreur FFmpeg**
   - Installer FFmpeg
   - Définir le chemin FFmpeg dans le code

3. **Erreur API**
   - Vérifier les clés API
   - Considérer les limites API

4. **Erreur Webhook**
   - Vérifier le certificat SSL
   - Définir l'URL webhook correcte

## Support

Pour le support et les rapports de bugs, veuillez contacter le développeur.

## Licence

Ce projet est sous licence MIT.