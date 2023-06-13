<?php
// Gestion des erreurs probables
error_reporting(E_ALL);
ini_set('display_errors', '1');
// ----------------------------
// Load automatically all class files
require __DIR__ . "/lib/class_autoloader.php";
spl_autoload_register('class_autoloader');
// ----------------------------

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$templateRenderer = new TemplateRenderer();

$authController = new AuthController();
$authController->setTemplateRenderer($templateRenderer);
$authController->sessionController();

$usersController = new UsersController();

$adminController = new AdminController();
$adminController->setTemplateRenderer($templateRenderer);


switch ($uri) {
    case '/':
        echo "home";
        break;

    case '/login':
        echo $authController->login();
        break;

    case '/create':
        // $userController->show_user_form_create();
        break;

    case '/operator/dashboard/':
        echo "operator";
        break;

    case '/logout':
        $authController->logout();
        break;

        case '/api/user':
            $userApi = new UserApi();
            if (isset($_GET['userId'])) {
                $userId = $_GET['userId'];
                $userApi->getUser($userId);
            } else {
                $userApi->sendResponse(400, ['error' => 'Missing userId parameter']);
            }
            break;

    case '/admin/dashboard':
        echo $adminController->Dashboard();
        break;
    default:
        http_response_code(404);
        include_once "views/page_not_found.php";
        break;
}
