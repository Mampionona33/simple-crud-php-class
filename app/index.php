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


switch ($uri) {
    case '/':
        echo $visitorController->getVoters();
        break;

    case '/login':
        echo $authController->login();
        break;

    case '/create':
        // $userController->show_user_form_create();
        break;

    case '/operator/dashboard':
        echo $operatorController->getVoters();
        break;

    case '/logout':
        $authController->logout();
        break;

    default:
        if (preg_match('/api/i', $uri)) {
            $voterApi = new VotersApi();
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['id_voter'])) {
                    $id_voter = $_GET['id_voter'];
                    $voterApi->getVoter($id_voter);
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $requestData = json_decode(file_get_contents('php://input'), true);
                $voterApi->createVoter($requestData);
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
