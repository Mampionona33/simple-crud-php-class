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
        $voter = $this->votersModel->getVoter($id_voter);
        // Vérifiez si l'utilisateur existe
        if (!$voter) {
            $this->sendResponse(404, ['error' => 'User not found']);
            return;
        }

        // Renvoyez les données de l'utilisateur au format JSON
        $this->sendResponse(200, $voter);
    }
}