<?php
class UserApi extends Api
{
    private $usersModel;
    private $id_key;
    public function __construct()
    {
        $this->usersModel = new UsersModel;
        $this->id_key = "id_user";
    }

    public function getUser(int $id_user)
    {
        if (isset($_GET[$this->id_key])) {
            $user = $this->usersModel->getUser($id_user);
            if (!$user) {
                $this->sendResponse(404, ['error' => 'User not found']);
                return;
            }

            // $hashedPassword = password_hash($user["password"], PASSWORD_BCRYPT);
            // $user["password"] = $hashedPassword;

            $this->sendResponse(200, [$user]);
        }
    }


    public function createUser($data)
    {
        // if (isset($data["password"])) {
        //     $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);
        //     $data["password"] = $hashedPassword;
        // }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $createdUser = $this->usersModel->createUser($data);
            if ($createdUser) {
                $this->sendResponse(201, ["message" => "User created successfully!!"]);
                exit;
            } else {
                $this->sendResponse(500, ['error' => 'Error creating user']);
                exit;
            }
        }

        $this->sendResponse(400, ['error' => 'Invalid request']);
    }
}
