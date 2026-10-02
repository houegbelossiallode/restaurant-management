# Déploiement sur Render

1. Poussez le dépôt sur GitHub ou GitLab, puis choisissez **New > Blueprint** dans Render et sélectionnez ce dépôt. Render détecte `render.yaml` et crée le service web ainsi que PostgreSQL.
2. Renseignez `APP_URL` avec l'URL HTTPS attribuée au service, puis `ADMIN_NAME`, `ADMIN_EMAIL` et `ADMIN_PASSWORD` dans les variables d'environnement du service. Utilisez un mot de passe unique et fort. Ces variables ne sont pas enregistrées dans Git.
3. Déclenchez un déploiement. Au démarrage, le conteneur exécute les migrations et crée le compte administrateur si les variables `ADMIN_*` sont renseignées. Connectez-vous ensuite avec cet e-mail et ce mot de passe.

Si vous ajoutez ces variables après le premier déploiement, le redémarrage suivant exécutera le seeder et créera le compte. Il ne remplace pas le mot de passe d'un compte existant.

Le plan gratuit Render peut suspendre le service et sa base de données gratuite n'est pas destinée à conserver durablement des données de production. Passez à des plans payants avant d'utiliser l'application avec des données réelles. Les fichiers écrits dans le conteneur ne sont pas persistants.