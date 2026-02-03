<?php
require_once __DIR__ . '/../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $inputPassword = $_POST['password'];

    if ($email === 'spider100@gmail.com') {
        // Use bcrypt for this specific user
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND confirmed = 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        
        if ($user) {
            if (password_verify($inputPassword, $user['password'])) {
                // Auth success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];

                // Generate weak JWT-like token
                $header = base64_encode(json_encode(['alg'=>'HS256','typ'=>'JWT']));
                $payload = base64_encode(json_encode(['id'=>$user['id'],'username'=>$user['username']]));
                $signature = md5($header . $payload . 'weak_secret');
                $_SESSION['jwt'] = "$header.$payload.$signature";

                header('Location: index.php');
                exit;
            }
        }
    } else {
        // Fallback: use MD5 (not recommended)
        $password = md5($inputPassword);
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND confirmed = 1";
        $stmt = $conn->query($sql);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            // Generate weak JWT-like token
            $header = base64_encode(json_encode(['alg'=>'HS256','typ'=>'JWT']));
            $payload = base64_encode(json_encode(['id'=>$user['id'],'username'=>$user['username']]));
            $signature = md5($header . $payload . 'weak_secret');
            $_SESSION['jwt'] = "$header.$payload.$signature";

            header('Location: index.php');
            exit;
        }
    }

    $message = "Invalid credentials or account not confirmed!";
}

include __DIR__ . '/../../templates/auth/login_form.php';
