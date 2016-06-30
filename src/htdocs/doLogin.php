<?php

require_once 'includes/common.php';
require_once 'jwrCommonsPhp/util/FormLogin.php';
require_once 'jwrCommonsPhp/Logger.php';

$f = new FormLogin();

if ($f->validate()) {
	try {
		$username = $f->getElementValue('username');
		Session::checkCredentials($username, $f->getElementValue('password'));

		setcookie('mylocation', Session::getUseR()->getData('location'));

		redirect('index.php', 'You have logged in.');
	} catch (IncorrectPasswordException $e) {
		Logger::messageNormal('Failed login for ' . $username . ', password wrong.');

		$f->setElementError('password', 'Password wrong.');
	} catch (UserNotFoundException $e) {
		Logger::messageNormal('Failed login for ' . $username . ', nonexistant user.');

		$f->setElementError('username', 'User not found');
	}
}

require_once 'includes/widgets/header.php';

$tpl->assignForm($f);
$tpl->display('login.tpl');

require_once 'includes/widgets/footer.php';

?>
