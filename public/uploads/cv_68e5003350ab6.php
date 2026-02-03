%PDF-1.5
<?php
// Activation du débogage pour afficher les erreurs directement (désactive en production).
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Test des sessions avec log pour débogage.
try {
    session_start();
    file_put_contents('debug.log', "Session démarrée à " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
} catch (Exception $e) {
    file_put_contents('debug.log', "Erreur session : " . $e->getMessage() . "\n", FILE_APPEND);
    die("Erreur : Vérifiez les sessions dans php.ini. Détails dans debug.log.");
}

// Gestion du formulaire POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if ($password === 'hacker123') {
        $_SESSION['authenticated'] = true;
        header('Location: simulator.php');
        exit;
    } else {
        $error = 'Mot de passe incorrect. Essayez encore.';
        file_put_contents('debug.log', "Échec login à " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Simulateur Webshell</title>
    <style>
        body { background-color: #000; color: #0f0; font-family: monospace; text-align: center; padding: 100px; }
        form { margin: 20px; }
        input[type="password"] { background: #111; color: #0f0; border: 1px solid #0f0; padding: 10px; width: 200px; }
        input[type="submit"] { background: #0f0; color: #000; border: none; padding: 10px; cursor: pointer; }
        .glitch { animation: glitch 1s infinite; }
        @keyframes glitch { 0% { text-shadow: 0.05em 0 0 #f00, -0.05em 0 0 #0ff; } 50% { text-shadow: -0.05em 0 0 #f00, 0.05em 0 0 #0ff; } 100% { text-shadow: 0.05em 0 0 #f00, -0.05em 0 0 #0ff; } }
        .error { color: #f00; }
    </style>
</head>
<body>
    <h1 class="glitch">Accès Restreint : Simulateur Webshell Pro</h1>
    <p>Entrez le mot de passe pour accéder (Pédagogique seulement).</p>
    <form method="POST">
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="submit" value="Connexion">
    </form>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <p><strong>Débogage :</strong> Vérifiez debug.log si la page ne charge pas correctement.</p>
</body>
</html>