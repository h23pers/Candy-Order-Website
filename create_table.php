<?php	

require 'functions.php';

if ($_GET['passwd'] == "test1") {
	
	$mysqli = databaseConnect();
	
	$dropquery = "DROP TABLE IF EXISTS `PM4Orders`";
	
	$createquery = "CREATE TABLE IF NOT EXISTS `PM4Orders` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`date` datetime NOT NULL,
		`name` varchar(24) NOT NULL,
		`phone` varchar(16) NOT NULL,
		`address` varchar(32) NOT NULL,
		`city` varchar(24) NOT NULL,
		`state` varchar(16) NOT NULL,
		`zip` varchar(5) NOT NULL,
		`candy_size` varchar(24) NOT NULL,
		`quantity` int NOT NULL,
		`candy_type` text,
		`status` varchar(16) DEFAULT 'active',
		PRIMARY KEY (`id`)
	)";
	
	if (!$mysqli->query($dropquery)) {
		echo 'Table drop failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	else if (!$mysqli->query($createquery)) {
		echo 'Table create failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	else {
		echo 'Table created';
	}
}
else {
	echo 'Access denied';
}
?>
