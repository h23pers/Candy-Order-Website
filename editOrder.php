<?php
require 'functions.php';
$title = "Edit Order";
echo createHeader($title);	
if (isset($_SESSION['admin'])){
	if ($_GET['action'] == "submit"){
		updateOrder($_GET['id']);
		header("location: /project2/admin.php");
	}
	else{

	$row = getOrder($_GET['id']);

	echo editOrder($row);
	header("location: /project2/editOrder.php");
}
}
echo createFooter($title);	
	

?>