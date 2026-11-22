<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Contact.php';
require_once __DIR__ . '/controllers/ContactController.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    die('Database connection ($pdo) is not initialized in config/database.php.');
}

$controller = new ContactController($pdo);
$action = (string)($_GET['action'] ?? 'index');

switch ($action) {
    case 'login':
        $controller->login();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->delete();
        } else {
            header('Location: index.php');
            exit;
        }
        break;
    case 'index':
    default:
        $controller->index();
        break;
}