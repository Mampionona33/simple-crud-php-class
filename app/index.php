<?php
// Gestion des erreurs probables
error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------
// Load automaticaly all class files
require __DIR__ . "/lib/class_autoloader.php";
spl_autoload_register('class_autoloader');
// ----------------------------

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$userController = new UserController();

switch ($uri) {
    case '/':
        if (isset($_GET)) {
            http_response_code(200);
            $userController->show_user_list();
        }
        break;

    case '/list':
        break;

    default:
        http_response_code(404);
        include_once "views/page_not_found.php";
        break;
}

