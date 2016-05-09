<?php

require 'functions.php';




$title = 'Candy.com - View Active Orders';

echo createHeader($title);

if (isset($_SESSION['admin'])) {
	echo displayOrderControlPanel("PM4Orders");
}
else {
  header("location: /project2/login.php");
}

echo createFooter($title);

?>