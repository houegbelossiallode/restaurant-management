# Déploiement sur Render

1. Créez une base PostgreSQL sur Aiven et récupérez son URI de connexion.
2. Poussez le dépôt sur GitHub ou GitLab, puis choisissez **New > Blueprint** dans Render et sélectionnez ce dépôt. Render crée le service web à partir de `render.yaml`.
3. Dans les variables d'environnement du service Render, renseignez `DB_URL` avec l'URI Aiven (elle doit utiliser `sslmode=require`), `APP_URL` avec l'URL HTTPS Render, et `ADMIN_NAME`, `ADMIN_EMAIL` et `ADMIN_PASSWORD`. Utilisez un mot de passe unique et fort. Ne placez pas ces valeurs dans Git.
4. Pour l'envoi des courriels, configurez `MAIL_USERNAME` avec l'identifiant SMTP affiché dans Brevo, `MAIL_PASSWORD` avec la clé SMTP (pas la clé API) et `MAIL_FROM_ADDRESS` avec une adresse d'expéditeur vérifiée dans Brevo. Le serveur, le port et le nom d'expéditeur sont préremplis par le blueprint. Ne mettez jamais ces identifiants dans Git.
5. Déclenchez le déploiement. Au démarrage, le conteneur exécute les migrations et crée le compte administrateur si les variables `ADMIN_*` sont renseignées. Connectez-vous ensuite avec cet e-mail et ce mot de passe.

Si vous ajoutez ces variables après le premier déploiement, redéployez le service pour appliquer les changements. Le redémarrage exécutera aussi le seeder et créera le compte administrateur s'il n'existe pas. Il ne remplace pas le mot de passe d'un compte existant.

La base Aiven et le service Render sont deux services distincts : vérifiez que votre offre Aiven autorise les connexions depuis Render et prévoyez le coût et la persistance selon vos besoins. Les fichiers écrits dans le conteneur Render ne sont pas persistants.