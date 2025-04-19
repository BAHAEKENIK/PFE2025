<!DOCTYPE html>
<html>
<head>
    <title>Réinitialisation de mot de passe</title>
</head>
<body>
    <h1>Code de réinitialisation</h1>
    <p>Bonjour,</p>
    <p>Vous avez demandé une réinitialisation de mot de passe. Utilisez le code suivant pour continuer :</p>
    <p style="font-size: 24px; font-weight: bold; letter-spacing: 5px;">{{ $code }}</p>
    <p>Ce code expirera bientôt.</p>
    <p>Si vous n'avez pas demandé cette réinitialisation, vous pouvez ignorer cet email.</p>
    <p>Merci,<br>{{ config('app.name') }}</p>
</body>
</html>
