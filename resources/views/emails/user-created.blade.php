<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre compte a été créé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #050505;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            border-bottom: 2px solid #d4af37;
        }
        .header img {
            display: block;
            width: 190px;
            max-width: 100%;
            height: auto;
            margin: 0 auto 18px;
        }
        .header h1 {
            color: #f2d46b;
            margin: 0;
            font-size: 24px;
        }
        .content {
            background-color: white;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .content p {
            color: #374151;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .content strong {
            color: #1f2937;
        }
        .password-box {
            background-color: #fffdf5;
            border: 2px solid #d4af37;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .password-box p {
            margin: 0;
            color: #6d5312;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            background-color: #111111;
            color: #f2d46b;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $message->embed(public_path('images/logo-mahouenan.jpeg')) }}" alt="Complexe Mawouenan Kokouvi Ayi et Fils">
            <h1>Bienvenue !</h1>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $user->name }}</strong>,</p>
            
            <p>Votre compte a été créé avec succès sur notre application de gestion de restaurant.</p>
            
            <p>Voici vos informations de connexion :</p>
            
            <div style="margin: 20px 0;">
                <p><strong>Email :</strong> {{ $user->email }}</p>
            </div>
            
            <div class="password-box">
                <p>Mot de passe : {{ $password }}</p>
            </div>
            
            <p style="color: #dc2626; font-size: 14px; margin-top: 20px;">
                ⚠️ Pour des raisons de sécurité, nous vous recommandons vivement de changer votre mot de passe après votre première connexion.
            </p>
            
            <div style="text-align: center;">
                <a href="{{ config('app.url') }}" class="button">Se connecter</a>
            </div>
            
            <p style="margin-top: 30px;">Si vous avez des questions, n'hésitez pas à nous contacter.</p>
            
            <p>Cordialement,<br>L'équipe de gestion de restaurant</p>
        </div>
        <div class="footer">
            <p>Cet email a été envoyé automatiquement. Merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
