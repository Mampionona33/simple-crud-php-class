<?php
class UserApi extends Api {
    private $usersModel;

    public function __construct() {
        $this->usersModel = new UsersModel();
    }

    public function getUser($userId) {
        $user = $this->usersModel->getUser($userId);
        // Vérifiez si l'utilisateur existe
        if (!$user) {
            $this->sendResponse(404, ['error' => 'User not found']);
            return;
        }

        // Renvoyez les données de l'utilisateur au format JSON
        $this->sendResponse(200, $user);
    }
}
