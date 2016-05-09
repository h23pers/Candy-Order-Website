<?php

require 'functions.php';

$title = 'Login ';

echo createHeader($title);

if ($_GET['action']=="submit") {
		echo processLoginForm();
}
else {
		echo createLoginForm();
}

if ($_GET['action']=="logout") {
		session_destroy();
		header("location: /project2/login.php");
}

echo createFooter($title);

?>