%PDF-1.5
<?php
// Activation du débogage.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérification des sessions.
session_start();
if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
    header('Location: login.php');
    exit;
}

// Gestion du logout.
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Gestion des actions POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : 'cmd';
    $output = '';
    file_put_contents('debug.log', "Action {$action} exécutée à " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

    if ($action === 'cmd') {
        $command = isset($_POST['command']) ? trim($_POST['command']) : '';
        $simulated_responses = [
            'ls' => 'fichier1.txt fichier2.php dossier/ secret.conf — (Simulé : Liste étendue)',
            'whoami' => 'www-data — (Simulé : Utilisateur web)',
            'pwd' => '/var/www/html — (Simulé : Chemin courant)',
            'cat /etc/passwd' => 'root:x:0:0:... (Simulé : Fuite de données sensibles)',
            'rm -rf /' => 'Opération destructive simulée — Système "effacé" (mais pas vraiment !)',
            'ifconfig' => 'eth0: 192.168.1.1 ... (Simulé : Infos réseau)',
            'ps aux' => 'USER PID %CPU ... www-data 1234 ... (Simulé : Processus en cours)',
        ];
        $output = !empty($command) ? ($simulated_responses[$command] ?? "Commande inconnue : {$command} — Simulé : Échec.") : '';
    } elseif ($action === 'upload') {
        $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : 'inconnu';
        $output = "Fichier '{$file_name}' uploadé (simulé) — Contenu non stocké.";
    } elseif ($action === 'browse') {
        $dir = isset($_POST['dir']) ? $_POST['dir'] : '/';
        $output = "Contenu de {$dir} : fichier1, dossier2 — (Simulé : Pas de vrai scan).";
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
        body { background: #000; color: #0f0; font-family: monospace; padding: 20px; }
        .tabs { display: flex; margin-bottom: 20px; }
        .tab { background: #111; color: #0f0; padding: 10px; margin-right: 5px; cursor: pointer; border: 1px solid #0f0; }
        .tab.active { background: #0f0; color: #000; }
        form { display: none; margin: 20px 0; }
        form.active { display: block; }
        input[type="text"], input[type="file"] { background: #111; color: #0f0; border: 1px solid #0f0; padding: 10px; width: 80%; }
        input[type="submit"] { background: #0f0; color: #000; border: none; padding: 10px; cursor: pointer; }
        pre { background: #111; padding: 10px; border: 1px solid #0f0; animation: scanline 0.5s infinite; }
        @keyframes scanline { 0% { box-shadow: 0 0 10px #0f0; } 50% { box-shadow: 0 0 5px #0f0; } 100% { box-shadow: 0 0 10px #0f0; } }
        a { color: #f00; text-decoration: none; }
    </style>
    <script>
        function showTab(tabName) {
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('form').forEach(form => form.classList.remove('active'));
            document.getElementById(tabName + '-tab').classList.add('active');
            document.getElementById(tabName + '-form').classList.add('active');
        }
    </script>
</head>
<body>
    <h1>Simulateur Webshell Pro (Éducatif)</h1>
    <p>Aucune exécution réelle. Utilisez les onglets pour simuler des fonctionnalités.</p>
    
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
    
    <p><a href="?logout">Déconnexion</a></p>
    <p><strong>Avertissement :</strong> Outil pédagogique seulement. Vérifiez debug.log pour les logs.</p>
</body>
</html>