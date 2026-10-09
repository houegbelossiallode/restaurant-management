<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>Votre compte est prêt</title>
</head>
<body style="margin:0;padding:0;background-color:#f1f2f0;font-family:Arial,Helvetica,sans-serif;color:#202321;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0;color:transparent;">
        Votre compte sur {{ config('app.name', 'Restaurant Management') }} est prêt. Voici vos informations de connexion.
    </div>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f1f2f0;border-collapse:collapse;">
        <tr>
            <td align="center" style="padding:32px 14px;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:600px;border-collapse:collapse;background-color:#ffffff;">
                    <tr>
                        <td align="center" style="padding:30px 24px 26px;background-color:#111412;border-bottom:4px solid #c5a45b;">
                            <img src="{{ $message->embed(public_path('images/logo-mahouenan.jpeg')) }}" width="168" alt="Complexe Mawouenan Kokouvi Ayi et Fils" style="display:block;width:168px;max-width:100%;height:auto;margin:0 auto 20px;border:0;">
                            <p style="margin:0 0 8px;color:#d8bf82;font-size:11px;font-weight:bold;text-transform:uppercase;">Accès au compte</p>
                            <h1 style="margin:0;color:#ffffff;font-size:25px;line-height:1.3;font-weight:600;">Bienvenue, {{ $user->name }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 34px 12px;">
                            <p style="margin:0 0 14px;color:#343936;font-size:15px;line-height:1.65;">Votre compte sur <strong>{{ config('app.name', 'Restaurant Management') }}</strong> a été créé. Utilisez les identifiants ci-dessous pour vous connecter.</p>
                            <p style="margin:0 0 18px;color:#6b716d;font-size:13px;line-height:1.6;">VOS INFORMATIONS DE CONNEXION</p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;border:1px solid #e2e5e2;">
                                <tr>
                                    <td width="110" style="padding:14px 16px;background-color:#f7f8f6;border-bottom:1px solid #e2e5e2;color:#656b66;font-size:13px;">Adresse email</td>
                                    <td style="padding:14px 16px;border-bottom:1px solid #e2e5e2;color:#202321;font-size:14px;font-weight:bold;word-break:break-word;">{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td width="110" style="padding:14px 16px;background-color:#f7f8f6;color:#656b66;font-size:13px;">Mot de passe</td>
                                    <td style="padding:14px 16px;color:#202321;font-family:Consolas,Monaco,'Courier New',monospace;font-size:15px;font-weight:bold;word-break:break-all;">{{ $password }}</td>
                                </tr>
                            </table>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:18px;border-collapse:collapse;background-color:#fff8e8;border-left:3px solid #c5a45b;">
                                <tr>
                                    <td style="padding:13px 15px;color:#68562c;font-size:13px;line-height:1.6;">
                                        <strong>Conseil de sécurité</strong><br>
                                        Changez votre mot de passe après votre première connexion et ne le partagez avec personne.
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" align="center" style="margin:26px auto 22px;border-collapse:collapse;">
                                <tr>
                                    <td align="center" bgcolor="#c5a45b" style="background-color:#c5a45b;">
                                        <a href="{{ config('app.url') }}" style="display:inline-block;padding:14px 28px;color:#171915;font-size:14px;font-weight:bold;text-decoration:none;">Ouvrir l’application</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 14px;color:#555b56;font-size:14px;line-height:1.65;">Si vous n’attendiez pas la création de ce compte, contactez l’administrateur de votre établissement.</p>
                            <p style="margin:0 0 24px;color:#555b56;font-size:14px;line-height:1.65;">Cordialement,<br><strong>{{ config('app.name', 'Restaurant Management') }}</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:18px 24px;background-color:#f7f8f6;border-top:1px solid #e2e5e2;color:#777d78;font-size:11px;line-height:1.6;">
                            Ce message a été envoyé automatiquement. Merci de ne pas y répondre.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
