<?php

require 'functions.php';

$title = 'Add Admin Form';

echo createHeader($title);

if ($_GET['action']=="submit") {
		echo processAdminForm();
}
else {
		echo createAdminForm();
}

echo createFooter($title);

?>