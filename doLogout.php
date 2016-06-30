<?php

require_once 'includes/common.php';

use \libAllure\Session as Session;

if (Session::isLoggedIn()) {
	Session::logout();
}

redirect('index.php', 'See ya!');

?>
