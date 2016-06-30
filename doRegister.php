<?php

require_once 'includes/widgets/header.php';

require_once 'libAllure/util/FormRegister.php';
require_once 'libAllure/FormHandler.php';

use \libAllure\FormHandler;

$fh = new FormHandler('libAllure\FormRegister');
$fh->handle();


require_once 'includes/widgets/footer.php';

?>
