<?php

require_once 'includes/common.php';

use \libAllure\Session;

if (!Session::isLoggedIn()) {
	redirect('index.php', 'You need to be logged in.');
} else {
	setcookie('ttrssUser', Session::getUser()->getUsername());

	redirect('tools/ttrss/', 'Logged in to ttrss');
}

?>
