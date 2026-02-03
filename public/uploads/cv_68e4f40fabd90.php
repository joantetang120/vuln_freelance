%PDF-1.4

<?php
// AVERTISSEMENT : Code intentionnellement vulnérable pour lab local éducatif UNIQUEMENT.
// NE PAS UTILISER EN PRODUCTION OU SUR INTERNET.

// Connexion DB
function getDb() {
    $host = 'localhost'; // Ou 'db' pour Docker
    $dbname = 'vuln_app';
    $user = 'root';
    $pass = ''; // Ou 'root' pour Docker
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

// Installation de la DB si ?install=1
if (isset($_GET['install']) && $_GET['install'] == 1) {
    try {
        $host = 'localhost'; // Ou 'db' pour Docker
        $user = 'root';
        $pass = ''; // Ou 'root' pour Docker
        $dbname = 'vuln_app';
        $pdo = new PDO("mysql:host=$host", $user, $pass);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
        $pdo = getDb();
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                password VARCHAR(50) NOT NULL
            )
        ");
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL
            )
        ");
        $pdo->exec("INSERT INTO users (username, password) VALUES ('admin', 'password')");
        $pdo->exec("INSERT INTO items (name) VALUES ('Item 1'), ('Item 2'), ('Item 3')");
        echo "Base de données et tables créées avec succès.";
        exit;
    } catch (PDOException $e) {
        die("Erreur d'installation : " . $e->getMessage());
    }
}

// Gestion des pages via ?page=
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$output = '';

// Traitement des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($page === 'login') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            // VULNÉRABILITÉ : Injection SQL
            // Explication : Les inputs ne sont pas sanitizés, permettant des injections comme ' OR '1'='1 -- pour bypasser le login.
            // Correction : Utilisez des prepared statements, e.g., $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?"); $stmt->execute([$username, $password]);
            $pdo = getDb();
            $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = $pdo->query($query);
            $output = $result->rowCount() > 0 ? "<p class='success'>Login réussi !</p>" : "<p class='error'>Échec du login.</p>";
        } elseif ($page === 'upload' && isset($_FILES['file'])) {
            $uploadDir = 'uploads/';
            $fileName = basename($_FILES['file']['name']);
            $uploadPath = $uploadDir . $fileName;
            // VULNÉRABILITÉ : Upload Non Sécurisé
            // Explication : Pas de vérification de type MIME ou extension, permettant upload de .php malveillants exécutables via le navigateur.
            // Correction : Vérifiez $_FILES['file']['type'], limitez aux extensions (jpg, png), utilisez move_uploaded_file avec checks, stockez hors du web root.
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)) {
                $output = "<p class='success'>Fichier uploadé : <a href='$uploadPath'>$fileName</a></p>";
            } else {
                $output = "<p class='error'>Échec de l'upload.</p>";
            }
        } elseif ($page === 'command') {
            $cmd = $_POST['cmd'];
            // VULNÉRABILITÉ : Exécution de Commandes Non Sécurisée
            // Explication : Exécute directement les commandes système sans sanitization, permettant des attaques comme `; rm -rf /`.
            // Correction : Restreindre les commandes autorisées, utiliser escapeshellcmd() ou désactiver complètement exec() en production.
            $output = "<pre>";
            exec($cmd, $cmd_output);
            $output .= htmlspecialchars(implode("\n", $cmd_output));
            $output .= "</pre>";
        } elseif ($page === 'filemanager' && isset($_POST['delete'])) {
            $file = 'uploads/' . basename($_POST['delete']);
            // VULNÉRABILITÉ : Suppression Non Sécurisée
            // Explication : Pas de validation du chemin, permettant des attaques comme la suppression de fichiers hors du dossier uploads/.
            // Correction : Vérifiez que le fichier est dans uploads/ avec realpath() et basename().
            if (file_exists($file) && unlink($file)) {
                $output = "<p class='success'>Fichier supprimé : " . htmlspecialchars(basename($file)) . "</p>";
            } else {
                $output = "<p class='error'>Échec de la suppression.</p>";
            }
        }
    } catch (Exception $e) {
        $output = "<p class='error'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

// Recherche (GET)
if ($page === 'search' && isset($_GET['query'])) {
    $query = $_GET['query'];
    // VULNÉRABILITÉ : XSS Réfléchi
    // Explication : L'input est echo directement sans escaping, permettant <script>alert('XSS')</script> pour exécuter du JS.
    // Correction : Utilisez htmlspecialchars($query, ENT_QUOTES) pour escaping.
    $output .= "<p>Résultat pour : $query</p>";
    try {
        $pdo = getDb();
        $stmt = $pdo->prepare("SELECT * FROM items WHERE name LIKE ?");
        $stmt->execute(["%$query%"]);
        $results = $stmt->fetchAll();
        if ($results) {
            $output .= "<ul>";
            foreach ($results as $item) {
                $output .= "<li>" . htmlspecialchars($item['name']) . "</li>";
            }
            $output .= "</ul>";
        } else {
            $output .= "<p>Aucun résultat.</p>";
        }
    } catch (PDOException $e) {
        $output .= "<p class='error'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

// Gestionnaire de fichiers
if ($page === 'filemanager') {
    $uploadDir = 'uploads/';
    $files = array_diff(scandir($uploadDir), ['.', '..']);
    if ($files) {
        $output .= "<h3>Fichiers dans uploads/</h3><ul>";
        foreach ($files as $file) {
            $output .= "<li>" . htmlspecialchars($file) . " 
                <a href='$uploadDir$file'>Télécharger</a> 
                <form method='POST' action='?page=filemanager' style='display:inline;'>
                    <input type='hidden' name='delete' value='$file'>
                    <button type='submit' class='delete-btn'>Supprimer</button>
                </form></li>";
        }
        $output .= "</ul>";
    } else {
        $output .= "<p>Aucun fichier dans uploads/.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>WebShell Vulnérable</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #1a1a1a;
            color: #e0e0e0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #2a2a2a;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 255, 100, 0.2);
        }
        h1, h2, h3 {
            color: #00ff00;
        }
        a {
            color: #00cc00;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        form {
            background: #333;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"], input[type="file"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #00cc00;
            background: #222;
            color: #e0e0e0;
            border-radius: 4px;
        }
        button {
            background: #00cc00;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #009900;
        }
        .delete-btn {
            background: #cc0000;
        }
        .delete-btn:hover {
            background: #990000;
        }
        .success {
            color: #00ff00;
            background: #003300;
            padding: 10px;
            border-radius: 4px;
        }
        .error {
            color: #ff3333;
            background: #330000;
            padding: 10px;
            border-radius: 4px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
        }
        pre {
            background: #222;
            padding: 10px;
            border: 1px solid #00cc00;
            border-radius: 4px;
            max-height: 300px;
            overflow-y: auto;
        }
        .nav {
            margin-bottom: 20px;
        }
        .nav a {
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>WebShell Vulnérable - Lab de Sécurité</h1>
        <?php if ($page !== 'home'): ?>
            <div class="nav">
                <a href="?page=home">Accueil</a>
                <a href="?page=login">Login</a>
                <a href="?page=search">Recherche</a>
                <a href="?page=upload">Upload</a>
                <a href="?page=command">Commandes</a>
                <a href="?page=filemanager">Gestionnaire de Fichiers</a>
            </div>
        <?php endif; ?>

        <?php if ($page === 'home'): ?>
            <h2>Bienvenue dans le Lab de Sécurité</h2>
            <p>Ce webshell est intentionnellement vulnérable pour des tests éducatifs locaux. Fonctionnalités :</p>
            <ul>
                <li><a href="?page=login">Login (Injection SQL)</a></li>
                <li><a href="?page=search">Recherche (XSS Réfléchi)</a></li>
                <li><a href="?page=upload">Upload (Non Sécurisé)</a></li>
                <li><a href="?page=command">Exécution de Commandes (Non Sécurisée)</a></li>
                <li><a href="?page=filemanager">Gestionnaire de Fichiers (Suppression Non Sécurisée)</a></li>
            </ul>
        <?php elseif ($page === 'login'): ?>
            <h2>Login (Vulnérable à SQLi)</h2>
            <form method="POST" action="?page=login">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <?php echo $output; ?>
        <?php elseif ($page === 'search'): ?>
            <h2>Recherche (Vulnérable à XSS)</h2>
            <form method="GET" action="?page=search">
                <input type="text" name="query" placeholder="Rechercher..." required>
                <button type="submit">Chercher</button>
            </form>
            <?php echo $output; ?>
        <?php elseif ($page === 'upload'): ?>
            <h2>Upload de Fichiers (Vulnérable)</h2>
            <form method="POST" action="?page=upload" enctype="multipart/form-data">
                <input type="file" name="file" required>
                <button type="submit">Uploader</button>
            </form>
            <?php echo $output; ?>
        <?php elseif ($page === 'command'): ?>
            <h2>Exécution de Commandes (Vulnérable)</h2>
            <form method="POST" action="?page=command">
                <input type="text" name="cmd" placeholder="Entrez une commande (ex. whoami, ls)" required>
                <button type="submit">Exécuter</button>
            </form>
            <?php echo $output; ?>
        <?php elseif ($page === 'filemanager'): ?>
            <h2>Gestionnaire de Fichiers (Vulnérable)</h2>
            <?php echo $output; ?>
        <?php endif; ?>
    </div>
</body>
</html>