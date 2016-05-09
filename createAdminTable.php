<?php	

require 'functions.php';

if ($_GET['passwd'] == "poop1234") {
	createAdminTable();
}
else {
	echo 'Access denied';
}
?>
