<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

define('BASEPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Insert default admin if not exists
require_once "config/database.php";
$db = new Database();
$adminCheck = $db->conn->query("SELECT id FROM users WHERE username='admin'");
if ($adminCheck->num_rows == 0) {
    $password = password_hash('admin', PASSWORD_DEFAULT);
    $db->conn->query("INSERT INTO users (nama, username, password, role) VALUES ('Administrator', 'admin', '$password', 'admin')");
}

$url = isset($_GET['url']) ? $_GET['url'] : 'auth/login';
$url = explode('/', $url);

$controllerName = ucfirst($url[0]).'Controller';
$method = isset($url[1]) ? $url[1] : 'index';

$publicRoutes = [
    'auth' => ['login', 'proses', 'register', 'simpan', 'logout', 'index'],
];

if (!isset($_SESSION['user'])) {
    $allowed = isset($publicRoutes[$url[0]]) && in_array($method, $publicRoutes[$url[0]]);
    if (!$allowed) {
        header("Location:index.php?url=auth/login");
        exit;
    }
}

require_once "controllers/$controllerName.php";
$controller = new $controllerName;
$controller->$method();