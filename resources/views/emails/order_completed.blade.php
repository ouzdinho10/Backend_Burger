<!DOCTYPE html>
<html>
<head>
    <title>Votre commande est terminée</title>
</head>
<body>
    <p>Bonjour {{ $order->user->name }},</p>
    <p>Votre commande pour le burger {{ $order->burger->name }} a été complétée. Veuillez trouver la facture ci-jointe.</p>
    <p>Merci pour votre commande!</p>
</body>
</html>
