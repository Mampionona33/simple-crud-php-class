<?php
class OperatorController extends VisitorController
{
    public function getVoters(array $columns = array(), $condition = ""): string
    {
        $this->tableVoters->setBtnEditVisible(true);
        $this->tableVoters->setAddBtnVisible(true);
        $this->tableVoters->setBtnDeleteVisible(true);
        return parent::getVoters($columns, $condition);
    }
}
?>