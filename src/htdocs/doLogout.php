<?php

require_once 'includes/common.php';

if (Session::isLoggedIn()) {
	Session::logout();
}

redirect('index.php', 'See ya!');

?>
