<?php
class VotersApi extends Api
{
    private $votersModel;
    private $id_key;

    public function __construct()
    {
        $this->votersModel = new VotersModel();
        $this->id_key = "id_voter";
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

            // Renvoyez les données de l'électeur au format JSON
            $this->sendResponse(200, $voter);
        }
    }

    public function createVoter($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->requiredValue($data)) {
                $this->sendResponse(401, ['error' => 'Missing required value!!']);
                exit;
            }
            if (!$this->voterExist($data)) {
                if (!$this->validateAge($data)) {
                    $this->sendResponse(401, ['error' => 'The voter is not eligible']);
                    exit;
                }

                $createdVoter = $this->votersModel->createVoter($data);

                if ($createdVoter) {
                    $this->sendResponse(201, ["message" => "Voter created successfully!!"]);
                    exit;
                } else {
                    $this->sendResponse(500, ['error' => 'Error creating voter']);
                    exit;
                }
            } else {
                $this->sendResponse(401, ['error' => 'Duplicate voter']);
                exit;
            }
        }

        $this->sendResponse(400, ['error' => 'Invalid request']);
    }
    public function updateVoter($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if ($this->requiredValue($data)) {
                $this->sendResponse(401, ['error' => 'Missing required value!!']);
                exit;
            }

            if (!$this->validateAge($data)) {
                $this->sendResponse(401, ['error' => 'The voter is not eligible']);
                exit;
            }

            $updatedVoter = $this->votersModel->updateVoter($data, $this->id_key, $data["id_voter"]);

            if ($updatedVoter) {
                $this->sendResponse(200, ["message" => "Voter updated successfully!!"]);
                exit;
            } else {
                $this->sendResponse(500, ['error' => 'Error updating voter']);
                exit;
            }
        }

        $this->sendResponse(400, ['error' => 'Invalid request']);
    }

    public function deleteVoter($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if ($this->votersModel->deleteVoter("id_voter", $data["id_voter"])) {
                $this->sendResponse(200, ["message" => "Voter delete successfully!!"]);
                exit;
            } else {
                $this->sendResponse(500, ['error' => 'Error updating voter']);
                exit;
            }
        }
    }
    // Validations
    private function voterExist($data): bool
    {
        $condition = "name='" . $data["name"] . "' AND last_name='" . $data["last_name"] . "'AND birthday='" . $data["birthday"] . "' AND civility='" . $data["civility"] . "'";
        $voters = $this->votersModel->getVoters([], $condition);
        if (count($voters) > 0) {
            return true;
        }
        return false;
    }

    private function requiredValue($data): bool
    {
        if (!$data["name"] || !$data["last_name"] || !$data["birthday"] || !$data["adresse"]) {
            return true;
        }
        return false;
    }

    private function validateAge($data): bool
    {
        $age = date_diff(new DateTime(), new DateTime($data["birthday"]));
        if ($age->y >= 18) {
            return true;
        }
        return false;
    }
}
