<?php

function startupError($message)
{
    echo '<strong>Startup error: </strong>'.$message;

    exit;
}

(@include_once '../../vendor/autoload.php') or startupError('Could not include autoload.php, is Composer setup?');

$localConfigDir = '.';

@include_once 'common.local.php';

ErrorHandler::getInstance()->beGreedy();

$cfg = new ConfigFile;
$cfg->loadFromPaths([
    $localConfigDir,
    '/etc/technowax.net/',
]);

$tpl = new Template('technowaxNe');

$GLOBALS['cfg'] = $cfg;
$GLOBALS['tpl'] = $tpl;

use libAllure\DatabaseFactory;

DatabaseFactory::registerInstance(new Database($cfg->getDsn(), $cfg->get('DB_USER'), $cfg->get('DB_PASS')));
$db = DatabaseFactory::getInstance();
$GLOBALS['db'] = $db;

use libAllure\AuthBackend;
use libAllure\AuthBackendDatabase;

AuthBackend::setBackend(new AuthBackendDatabase);

use libAllure\Session;

Session::setSessionName('technowaxNe');
Session::setCookieLifetimeInSeconds(15552000);
Session::start();

date_default_timezone_set('UTC');

use libAllure\ConfigFile;
use libAllure\Database;
use libAllure\ErrorHandler;
use libAllure\Form;
use libAllure\Template;

Form::$fullyQualifiedElementNames = false;

require_once 'includes/functions.php'; // requires autoloader
