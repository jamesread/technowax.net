<?php

require_once 'includes/common.php';

\libAllure\ErrorHandler::getInstance()->beLazy();

require_once 'Mail.php';
require_once 'Mail/smtp.php';

$host = 'ssl://smtp.gmail.com';
$username = 'xconspirisist@gmail.com';
$password = 'leoc89NeTT163';

$smtp = new Mail_smtp(array('host' => $host, 'port' => 465, 'auth' => true, 'username' => $username, 'password' => $password));

$headers = array(
	'From' => '<xconspirisist@gmail.com>',
	'To' => '<xconspirisist@gmail.com>',
	'Subject' => 'Testing subject',
);

$content = 'This is some content';
$smtp->send('<xconspirisist@gmail.com>', $headers, $content);

echo "sent";

?>
