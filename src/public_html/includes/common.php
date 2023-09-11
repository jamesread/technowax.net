<?php

function startupError($message)
{
    echo '<strong>Startup error: </strong>' . $message;

    exit;
}


(@include_once '../../vendor/autoload.php') or startupError('Could not include autoload.php, is Composer setup?');

\libAllure\ErrorHandler::getInstance()->beGreedy();

$cfg = new \libAllure\ConfigFile();
$cfg->tryLoad([
    '/etc/technowax.net/'
]);

$tpl = new libAllure\Template('technowaxNe');

use libAllure\DatabaseFactory;

DatabaseFactory::registerInstance(new libAllure\Database($cfg->getDsn(), $cfg->get('DB_USER'), $cfg->get('DB_PASS')));

use libAllure\AuthBackend;
use libAllure\AuthBackendDatabase;

AuthBackend::setBackend(new AuthBackendDatabase());

use libAllure\Session;

Session::setSessionName('technowaxNe');
Session::setCookieLifetimeInSeconds(15552000);
Session::start();

date_default_timezone_set('UTC');

use libAllure\Sanitizer as Sanitizer;

use libAllure\Form as Form;

Form::$fullyQualifiedElementNames = false;

require_once 'includes/functions.php'; // requires autoloader
