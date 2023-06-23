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

$visitorController = new VisitorController($templateRenderer);

$operatorController = new OperatorController($templateRenderer);
$adminControllers = new AdminControllers($templateRenderer);

switch ($uri) {
    case '/':
        echo $visitorController->voterLists();
        break;

    case '/login':
        echo $authController->login();
        break;

    case '/admin/manage_voters':
        echo $adminControllers->routeManageVoters();
        break;
    case '/admin/manage_users':
        echo $adminControllers->routeManageUsers();
        break;

    case '/admin/dashboard':
        echo $adminControllers->dashboard();
        break;

    case '/operator/dashboard':
        echo $operatorController->voterLists();
        break;

    case '/logout':
        $authController->logout();
        break;

    default:
        if (preg_match('/api/i', $uri)) {
            $voterApi = new VotersApi();
            $userApi = new UserApi();
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['id_voter']) && str_contains($uri, "voter")) {
                    $id_voter = $_GET['id_voter'];
                    $voterApi->getVoter($id_voter);
                }
                if (isset($_GET['id_user']) && str_contains($uri, "users")) {
                    $id_user = $_GET["id_user"];
                    $userApi->getUser($id_user);
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $requestData = json_decode(file_get_contents('php://input'), true);
                if (str_contains($uri, "voter")) {
                    $voterApi->createVoter($requestData);
                } elseif (str_contains($uri, "users")) {
                    unset($requestData["confirm-password"]);
                    $userApi->createUser($requestData);
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                $requestData = json_decode(file_get_contents('php://input'), true);
                $voterApi->updateVoter($requestData);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $requestData = json_decode(file_get_contents('php://input'), true);
                $voterApi->deleteVoter($requestData);
            } else {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Invalid request method']);
            }
        } else {
            http_response_code(404);
            include_once "views/page_not_found.php";
        }
        break;
}