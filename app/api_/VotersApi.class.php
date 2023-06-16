<?php
class VotersApi extends Api
{
    private $votersModel;

    public function __construct()
    {
        $this->votersModel = new VotersModel();
    }

    public function getVoter($id_voter)
    {
        if (isset($_GET["id_voter"])) {
            $voter = $this->votersModel->getVoter($id_voter);
            // Vérifiez si l'utilisateur existe
            if (!$voter) {
                $this->sendResponse(404, ['error' => 'Voter not found']);
                return;
            }

            // Renvoyez les données de l'utilisateur au format JSON
            $this->sendResponse(200, $voter);
        }
    }

    public function createVoter($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->voterExist($data)) {
                $createdVoter = $this->votersModel->createVoter($data);
            } else {
                $this->sendResponse(401, ['error' => 'Duplicate voter']);
                exit;
            }

            if ($createdVoter) {
                $this->sendResponse(201, ["message" => "Voter create successfully!!"]);
                return;
            }
            $this->sendResponse(500, ['error' => 'Error creating voter']);
            return;
        }

        $this->sendResponse(400, ['error' => 'Invalid request']);
    }


    private function voterExist($data): bool
    {
        $condition = "name='" . $data["name"] . "'";
        $voters = $this->votersModel->getVoters([], $condition);
        if (count($voters) > 0) {
            return true;
        }
        return false;
    }

}