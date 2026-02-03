<?php
require_once __DIR__ . '/../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = $_GET['page'] ?? 'home';

if ($page === 'api/profile') {
    include __DIR__ . '/../src/api/profile.php';
    exit;
}

switch ($page) {
    // 🔹 Auth
    case 'login':
        include __DIR__ . '/../src/auth/login.php';
        break;
    case 'register':
        include __DIR__ . '/../src/auth/register.php';
        break;
    case 'logout':
        include __DIR__ . '/../src/auth/logout.php';
        break;

    // 🔹 Admin
    case 'admin':
        include __DIR__ . '/../src/admin/dashboard.php';
        break;
    case 'confirm_user':
        include __DIR__ . '/../src/admin/confirm_user.php';
        break;
    case 'delete_user':
        include __DIR__ . '/../src/admin/delete_user.php';
        break;
    case 'applications':
        include __DIR__ . '/../src/admin/applications.php';
        break;

    // 🔹 User
    case 'profile':
        include __DIR__ . '/../src/users/profile.php';
        break;

    // 🔹 Jobs
    case 'jobs':
        include __DIR__ . '/../src/jobs/list.php';
        break;
    case 'createjob':
        include __DIR__ . '/../src/jobs/create.php';
        break;
    case 'viewjob':
        include __DIR__ . '/../src/jobs/view.php';
        break;

    // 🔹 Messages
    case 'sendmsg':
        include __DIR__ . '/../src/messages/send.php';
        break;
    case 'inbox':
        include __DIR__ . '/../src/messages/inbox.php';
        break;
    case 'sentmsg':
        include __DIR__ . '/../src/messages/sent.php';
        break;
    case 'viewmsg':
        include __DIR__ . '/../src/messages/view.php';
        break;

    // 🔹 File download
    case 'download':
        include __DIR__ . '/../src/files/download.php';
        break;

    // 🔹 Default: Home page
    default:
        include __DIR__ . '/../templates/home.php';
        break;
}
?>
