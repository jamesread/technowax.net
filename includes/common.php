<?php

require_once 'vendor/autoload.php';
require_once 'includes/functions.php';

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

define('CFG_PASSWORD_SALT', '23kl4jh23kl4jh');

?>
