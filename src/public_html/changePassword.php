<?php

require_once 'includes/widgets/header.php';

use \libAllure\Form;
use \libAllure\AuthBackend;
use \libAllure\Session;
use \libAllure\ElementPassword;

class FormChangePassword extends Form {
    public function __construct() {
        parent::__construct(null, 'Change Password');

        $this->addElement(new ElementPassword('password1', 'Password'));
        $this->addElement(new ElementPassword('password2', 'Password (Confirm)'));
        $this->addDefaultButtons();
    }

    public function validateExtended() {
        if ($this->getElementValue('password1') != $this->getElementValue('password2')) {
            $this->getElement('password2')->setElementError('Password does not match.');
        }
    }

    public function process() {
        $sql = 'UPDATE users SET password = :password WHERE username = :username';
        $stmt = stmt($sql);
        $stmt->bindValue(':password', AuthBackend::getBackend()->hashPassword($this->getElementValue('password1')));
        $stmt->bindValue(':username', Session::getUser()->getUsername());
        $stmt->execute();
    }
}

$fh = newFormHandler('FormChangePassword');
$fh->setRedirect('viewAccount.php');
$fh->handle();

require_once 'includes/widgets/footer.php';

?>
