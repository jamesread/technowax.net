<?php

require_once 'includes/functions.php';

require_once 'libAllure/ErrorHandler.php';

\libAllure\ErrorHandler::getInstance()->beGreedy();

require_once 'libAllure/Template.php';

$tpl = new libAllure\Template('technowaxNe');

require_once 'libAllure/Database.php';

use libAllure\DatabaseFactory as DatabaseFactory;

DatabaseFactory::registerInstance(new libAllure\Database('mysql:dbname=technowaxNe', 'root', ''));

require_once 'libAllure/AuthBackend.php';
require_once 'libAllure/AuthBackendDatabase.php';

use libAllure\AuthBackend;
use libAllure\AuthBackendDatabase;

AuthBackend::setBackend(new AuthBackendDatabase());

require_once 'libAllure/User.php';
require_once 'libAllure/Session.php';

use libAllure\Session as Session;

Session::setSessionName('technowaxNe');
Session::setCookieLifetimeInSeconds(15552000);
Session::start();

date_default_timezone_set('UTC');

require_once 'libAllure/Sanitizer.php';

use libAllure\Sanitizer as Sanitizer;

require_once 'libAllure/Form.php';

use libAllure\Form as Form;

Form::$fullyQualifiedElementNames = false;

define('CFG_PASSWORD_SALT', '23kl4jh23kl4jh');

?>
