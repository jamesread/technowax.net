<?php

use libAllure\ElementTextbox;
use libAllure\ElementNumeric;

class FormTeamMaker extends \libAllure\Form
{
    public function __construct()
    {
        parent::__construct('formTeamMaker', 'Make teams');

        $this->addElement(new ElementTextbox('teamList', 'Member list', null, 'Separate members names by entering each user on a new line.'));
        $elementTeamCount = $this->addElement(new ElementNumeric('teamCount', 'Team count'));
        $elementTeamCount->setBounds(2, 100);

        $this->requireFields(array('teamList', 'teamCount'));
        $this->addDefaultButtons();
    }

    public function validateInternals()
    {
    }

    public function process()
    {
        $members = $this->getElementValue('teamList');
        $members = trim($members);
        $members = explode("\n", $members);
        shuffle($members);

        $teamCount = $this->getElementValue('teamCount') - 1;
        $membersPerTeam = count($members) / $teamCount;

        $teams = array();
        $currentTeam = 0;

        for ($i = 0; $i < count($members); $i++) {
            $currentTeam = ($currentTeam == $teamCount) ? 0 : $currentTeam + 1;

            if (!isset($teams[$currentTeam])) {
                $teams[$currentTeam] = array();
            }

            $teams[$currentTeam][] = $members[$i];
        }

        $this->completedTeamList = $teams;
    }

    public function renderOutput()
    {
        global $tpl;

        $tpl->assign('listTeams', $this->completedTeamList);
        $tpl->display('teamMakerResults.tpl');
    }
}
