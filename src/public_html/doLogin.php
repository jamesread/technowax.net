<?php

require_once 'includes/common.php';

$enableOpenId = $cfg->get('ENABLE_OPENID');

if ($enableOpenId) {
    $openId = new \libAllure\AuthBackendOpenId('http://technowax.net/');

    if (!$openId->getMode()) {
        if (isset($_REQUEST['openId'])) {
            $openId->login($_REQUEST['openId']);
        }
    } elseif ($openId->getMode() == 'cancel') {
    } else {
        if ($openId->getOpenId()->validate()) {
            \libAllure\Session::performLogin($openId->getEmail(), 'email');
        } else {
            echo 'no login :(';
        }
    }
}

use \libAllure\Logger;

$f = new \libAllure\util\FormLogin();

if ($f->validate()) {
    try {
        $username = $f->getElementValue('username');
        \libAllure\Session::checkCredentials($username, $f->getElementValue('password'));

        redirect('index.php', 'You have logged in.');
    } catch (\libAllure\IncorrectPasswordException $e) {
        Logger::messageNormal('Failed login for ' . $username . ', password wrong.');

        $f->setElementError('password', 'Password wrong.');
    } catch (\libAllure\UserNotFoundException $e) {
        Logger::messageNormal('Failed login for ' . $username . ', nonexistant user.');

        $f->setElementError('username', 'User not found');
    }
}

require_once 'includes/widgets/header.php';

$tpl->assignForm($f);
$tpl->assign('enableOpenId', $enableOpenId);
$tpl->display('login.tpl');

require_once 'includes/widgets/footer.php';

?>
